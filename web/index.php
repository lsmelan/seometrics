<?php

$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->get('/analyse/{checker}/{domain}', function ($checker, $domain) use($app) {
    $service = new App\Service\AnalyseService();

    if(!filter_var(gethostbyname($domain), FILTER_VALIDATE_IP)) {
        return $app->json(['Domain does not exist'], 404);
    }

    $response = $service->fetch($checker, $domain);

    return $app->json($response);
});

$app->run();
