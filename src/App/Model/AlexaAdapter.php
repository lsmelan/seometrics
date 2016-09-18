<?php
namespace App\Model;

class AlexaAdapter implements CheckerAdapter
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

    }

    public function getBackLinks()
    {

    }
}
