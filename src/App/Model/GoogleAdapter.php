<?php
namespace App\Model;
use Silex\Application;
use GuzzleHttp\Client;

class GoogleAdapter implements CheckerAdapter
{
    private $domain;
    private $app;
    private $httpClient;

    public function __construct($domain, Application $app)
    {
        $this->domain = $domain;
        $this->app = $app;
        $this->httpClient = new Client();
    }

    public function getPageRank()
    {
        //it has been discontinued
        return 'n/a';
    }

    public function getIndexedPages()
    {
        $res = $this->getResponse("q=site:$this->domain");
        return $res['queries']['request'][0]['totalResults'] ?? 'n/a';
    }

    public function getBackLinks()
    {
        $res = $this->getResponse("q=link:$this->domain");
        $total = $res['queries']['request'][0]['totalResults'] ?? 'n/a';
        $list = [];

        if (isset($res['items']) && is_array($res['items'])) {
            foreach ($res['items'] as $item) {
                $list[] = $item['link'];
            }
        }

        return ['total' => $total, 'list' => $list];
    }

    private function getResponse($queryOptions)
    {
        try {
            $apiKey = $this->app['config']['webservice']['google']['api_key'];
            $cx = $this->app['config']['webservice']['google']['cx'];
            $url = "https://www.googleapis.com/customsearch/v1?key=$apiKey&cx=$cx&$queryOptions";
            return json_decode($this->httpClient->request('GET', $url)->getBody()->getContents(), true);
        } catch (\Exception $e) {
            $this->app['monolog']->addError($e->getMessage() . ' - ' . $e->getFile());
            return [];
        }
    }
}
