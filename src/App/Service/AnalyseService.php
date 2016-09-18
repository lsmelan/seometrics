<?php
namespace App\Service;
use App\Model\CheckerAdapter;

class AnalyseService
{
    public static $checkers = [
        CheckerAdapter::GOOGLE => CheckerAdapter::GOOGLE,
        CheckerAdapter::ALEXA => CheckerAdapter::ALEXA
    ];

    public function fetch($checker, $domain)
    {
        $metrics = [];
        $checkers = [$checker];

        if (!isset(self::$checkers[$checker])) {
            $checkers = self::$checkers;
        }

        foreach ($checkers as $checker) {
            $adapter = $this->getAdapter($checker, $domain);
            $metrics[$checker] = $this->buildData($adapter);
        }

        return $metrics;
    }

    private function buildData(CheckerAdapter $adapter)
    {
        return [
            'page_rank' => $adapter->getPageRank(),
            'back_links' => $adapter->getBackLinks(),
            'indexed_pages' => $adapter->getIndexedPages(),
        ];
    }

    private function getAdapter($checker, $domain)
    {
        $className = 'App\\Model\\'. ucfirst($checker) . 'Adapter';
        return new $className($domain);
    }
}
