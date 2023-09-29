<?php

namespace App\Requests\Patient;

class ListRequest
{
    public $search;
    public $page;
    public $perPage;

    public function __construct($search, $page, $perPage)
    {        
        $this->search = $search;
        $this->page = (int)$page;
        $this->perPage = (int)$perPage;
    }

    public function getSearch()
    {
        return $this->search;
    }

    public function getPage() 
    {
        return $this->page;
    }

    public function getPerPage() 
    {
        return $this->perPage;
    }
}
