<?php

namespace App\Utils\Pagination;

class Pagination
{
    public $currentPage = 0;
    public $previousPage = null;
    public $nextPage = null;
    public $count = 0;
    public $totalPage = 0;
    public $perPage = 0;
    public $data = [];

    public function __construct($currentPage, $perPage, $count, $data)
    {
        $this->currentPage = (int)$currentPage;
        $this->perPage = (int)$perPage;
        $this->count = (int)$count;
        $this->data = $data;
        $this->totalPage = $this->getTotalPages();
        $this->previousPage = $this->getPreviousPage();
        $this->nextPage = $this->getNextPage();
    }

    public function getTotalPages()
    {
        return ceil($this->count / $this->perPage);
    }

    public function hasPrevious()
    {
        return $this->currentPage > 1;
    }

    public function getPreviousPage()
    {
        return $this->hasPrevious() ? $this->currentPage - 1 : null;
    }    

    public function hasNext()
    {
        return $this->currentPage < $this->getTotalPages();
    }

    public function getNextPage()
    {
        return $this->hasNext() ? $this->currentPage + 1 : null;
    }    
}
