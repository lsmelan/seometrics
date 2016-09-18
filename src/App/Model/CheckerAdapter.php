<?php
namespace App\Model;
use Silex\Application;

interface CheckerAdapter
{
    const ALL = 'all';
    const GOOGLE = 'google';
    const ALEXA = 'alexa';

    public function __construct($domain, Application $app);

    public function getPageRank();

    public function getIndexedPages();

    public function getBackLinks();
}
