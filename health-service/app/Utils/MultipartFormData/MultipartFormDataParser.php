<?php

namespace App\Utils\MultipartFormData;

use App\Utils\MultipartFormData\MultipartFormDataset;

class MultipartFormDataParser
{
    public static function parse()
    {
        //find method
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        $dataset = new MultipartFormDataset();

        //find headers
        $headers = getallheaders();
        $headers = array_change_key_case($headers, CASE_LOWER);

        $dataset->headers = $headers;

        //get cookies
        $cookies = $_COOKIE;
        $cookies = array_change_key_case($cookies, CASE_LOWER);
        $dataset->cookies = $cookies;

        $contentType = (array_key_exists("content-type", $dataset->headers)) ? $dataset->headers["content-type"] : "";        

        if ($method === "GET") {
            $dataset->params = $_GET;
            return $dataset;
        }

        if ($method === "POST") {
            $dataset->files = $_FILES;
            $dataset->params = $_POST;
            return $dataset;
        }
        
        $GLOBALS["_".$method] = [];        

        //get raw input data
        $rawRequestData = file_get_contents("php://input");
        if (!preg_match('/boundary=(.*)$/is', $contentType, $matches)) {
            return null;
        }

        $boundary = $matches[1];
        $bodyParts = preg_split('/\\R?-+' . preg_quote($boundary, '/') . '/s', $rawRequestData);
        array_pop($bodyParts);

        foreach ($bodyParts as $bodyPart) {
            if (empty($bodyPart)) {
                continue;
            }
            [$headers, $value] = preg_split('/\\R\\R/', $bodyPart, 2);
            $headers =self::parseHeaders($headers);
            if (!isset($headers['content-disposition']['name'])) {
                continue;
            }
            if (isset($headers['content-disposition']['filename'])) {
                $file = [
                    'name' => $headers['content-disposition']['filename'],
                    'type' => array_key_exists('content-type', $headers) ? $headers['content-type'] : 'application/octet-stream',
                    'size' => mb_strlen($value, '8bit'),
                    'error' => UPLOAD_ERR_OK,
                    'tmp_name' => null,
                ];

                if ($file['size'] > self::toBytes(ini_get('upload_max_filesize'))) {
                    $file['error'] = UPLOAD_ERR_INI_SIZE;
                } else {
                    $tmpResource = tmpfile();
                    if ($tmpResource === false) {
                        $file['error'] = UPLOAD_ERR_CANT_WRITE;
                    } else {
                        $tmpResourceMetaData = stream_get_meta_data($tmpResource);
                        $tmpFileName = $tmpResourceMetaData['uri'];
                        if (empty($tmpFileName)) {
                            $file['error'] = UPLOAD_ERR_CANT_WRITE;
                            @fclose($tmpResource);
                        } else {
                            fwrite($tmpResource, $value);
                            $file['tmp_name'] = $tmpFileName;
                            $file['tmp_resource'] = $tmpResource;
                        }
                    }
                }
                $file["size"] = self::toFormattedBytes($file["size"]);
                $_FILES[$headers['content-disposition']['name']] = $file;
                $dataset->files[$headers['content-disposition']['name']] = $file;
            } else {
                //parameters
                $dataset->params[$headers['content-disposition']['name']] = $value;

                if ($method !== "POST" && $method !== "GET") {
                    $GLOBALS["_".$method][$headers['content-disposition']['name']] = $value;
                }
            }
        }

        return $dataset;
    }

    private static function parseHeaders($headerContent)
    {
        $headers = [];
        $headerParts = preg_split('/\\R/s', $headerContent, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($headerParts as $headerPart) {
            if (!str_contains($headerPart, ':')) {
                continue;
            }
            [$headerName, $headerValue] = explode(':', $headerPart, 2);
            $headerName = strtolower(trim($headerName));
            $headerValue = trim($headerValue);
            if (!str_contains($headerValue, ';')) {
                $headers[$headerName] = $headerValue;
            } else {
                $headers[$headerName] = [];
                foreach (explode(';', $headerValue) as $part) {
                    $part = trim($part);
                    if (!str_contains($part, '=')) {
                        $headers[$headerName][] = $part;
                    } else {
                        [$name, $value] = explode('=', $part, 2);
                        $name = strtolower(trim($name));
                        $value = trim(trim($value), '"');
                        $headers[$headerName][$name] = $value;
                    }
                }
            }
        }
        return $headers;
    }

    private static function toFormattedBytes($bytes)
    {
        $precision = 2;
        $base = log($bytes, 1024);
        $suffixes = array('', 'K', 'M', 'G', 'T');

        return round(1024 ** ($base - floor($base)), $precision) . $suffixes[floor($base)];
    }    

    private static function toBytes($formattedBytes)
    {
        $units = ['B', 'K', 'M', 'G', 'T', 'P'];
        $unitsExtended = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        $number = (int)preg_replace("/[^0-9]+/", "", $formattedBytes);
        $suffix = preg_replace("/[^a-zA-Z]+/", "", $formattedBytes);

        //B or no suffix
        if(is_numeric($suffix[0])) {
            return preg_replace('/[^\d]/', '', $formattedBytes);
        }

        $exponent = array_flip($units)[$suffix] ?? null;
        if ($exponent === null) {
            $exponent = array_flip($unitsExtended)[$suffix] ?? null;
        }

        if($exponent === null) {
            return null;
        }
        return $number * (1024 ** $exponent);
    }    
}