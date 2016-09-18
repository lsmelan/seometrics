<?php
namespace App\Controller;
use App\Model\CheckerAdapter;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Service\AnalyseService;

class AnalyseController
{
    public function get(Request $request, Application $app)
    {
        try {
            $service = new AnalyseService($app);
            $domain = $request->get('domain');
            $checker = $request->get('checker', CheckerAdapter::ALL);
            $this->validate($checker, $domain);
            $response = $service->fetch($checker, $domain);
            return $app->json($response);
        } catch (\Exception $e) {
            return $app->json(['Invalid Request'], 404);
        }
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
            throw new \InvalidArgumentException;
        }
    }
}
