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
        $rank = 'n/a';

        try {
            $xml = simplexml_load_file("http://data.alexa.com/data?cli=10&url=$this->domain");

            if (isset($xml->SD->REACH) && $xml->SD->REACH instanceof \SimpleXMLElement) {
                $rank = (string) $xml->SD->REACH->attributes()->RANK;
            }
        } catch (\Exception $e) {
            $this->app['monolog']->addError($e->getMessage() . ' - ' . $e->getFile());
        }

        return $rank;
    }

    public function getIndexedPages(){}

    public function getBackLinks(){}
}
