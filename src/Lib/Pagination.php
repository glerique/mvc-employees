<?php

namespace App\Lib;

class Pagination
{
    private $total;
    private $perPage;
    private $currentPage;

    public function __construct($total, int $perPage = 10)
    {
        $this->total = $total;
        $this->perPage = $perPage;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }

    public function getCurrentPage()
    {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $this->currentPage = (int) strip_tags($_GET['id']);
        }
        return $this->currentPage;
    }

    public function getPages()
    {
        $pages = ceil($this->total / $this->perPage);
        return $pages;
    }
}
