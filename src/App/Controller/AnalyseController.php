<?php
namespace App\Controller;
use App\Model\CheckerAdapter;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Service\AnalyseService;

class AnalyseController
{
    private $service;

    public function __construct()
    {
        $this->service = new AnalyseService();
    }

    public function get(Request $request, Application $app)
    {
        $response = [];

        try {
            $domain = $request->get('domain');
            $checker = $request->get('checker', CheckerAdapter::ALL);
            $this->validate($checker, $domain);
            $response = $this->service->fetch($checker, $domain);
        } catch (\Exception $e) {
            $app->abort(404);
        }

        return $app->json($response);
    }

    private function validate($checker, $domain)
    {
        $valid = true;

        if(!filter_var(gethostbyname($domain), FILTER_VALIDATE_IP)) {
            $valid = false;
        }

        if (!isset(AnalyseService::$checkers[$checker]) && $checker != CheckerAdapter::ALL) {
            $valid = false;
        }

        if (!$valid) {
            throw new \HttpInvalidParamException;
        }
    }
}
