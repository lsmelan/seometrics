<?php
namespace App\Model;

interface CheckerAdapter
{
    const ALL = 'all';
    const GOOGLE = 'google';
    const ALEXA = 'alexa';

    public function __construct($domain);

    public function getPageRank();

    public function getIndexedPages();

    public function getBackLinks();
}
