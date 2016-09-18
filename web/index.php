<?php

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Rpodwika\Silex\YamlConfigServiceProvider(__DIR__."/../src/App/Config/settings.yml"));

$app->get('/analyse/{checker}/{domain}', 'App\\Controller\\AnalyseController::get');

$app->run();
