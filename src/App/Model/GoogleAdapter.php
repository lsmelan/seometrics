<?php
namespace App\Model;

class GoogleAdapter implements CheckerAdapter
{
    private $domain;

    public function __construct($domain)
    {
        $this->domain = $domain;
    }

    public function getPageRank()
    {
        return 'PageRank';
    }

    public function getIndexedPages()
    {
        return 'IndexedPages';
    }

    public function getBackLinks()
    {
        return 'BackLinks';
    }
}
