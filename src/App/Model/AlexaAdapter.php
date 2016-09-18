<?php
namespace App\Model;
use Silex\Application;

class AlexaAdapter implements CheckerAdapter
{
    private $domain;
    private $app;

    public function __construct($domain, Application $app)
    {
        $this->domain = $domain;
        $this->app = $app;
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
