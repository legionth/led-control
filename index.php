<?php
use Slim\Slim;
use LedControl\Service\LedControlService;

require_once 'vendor/autoload.php';

$loader = new Twig_Loader_Filesystem(array(__DIR__ . '/templates/', __DIR__ . '/pages/'));
$twig = new Twig_Environment($loader);

/**
 * create a controller action to view the given twig template $name
 *
 * @param string $name
 * @return callable
 */
$view = function ($name) use ($twig) {
	return function () use ($name, $twig) {
		echo $twig->render($name . '/view.html.twig');
	};
};
/**
 * create a controller action to PUT the given JSON file $name
 *
 * @param string $name
 * @return callable
 */

$slim = new Slim();

$get = function ($name) use ($slim) {
	return function () use ($name, $slim) {
		$revision = $slim->applicationData->fetchRevisionCurrent();

		$slim->etag($revision);

		$config = $slim->applicationData->fetchData($revision);

		$slim->response->headers->set('Content-Type', 'application/json');

		echo json_encode($config[$name]);
	};
};

$put = function ($name) use ($slim) {
	return function () use ($name, $slim) {
		$data = json_decode($slim->request->getBody());
		$schema = json_decode(file_get_contents(__DIR__ . '/pages/' . $name . '/schema.json'));

		$page = $data;

		$data = $slim->applicationData->fetchDataCurrent();
		$data[$name] = $page;
		$slim->applicationData->saveDataCurrent($data);

		$slim->response->setStatus(204); // no content
	};
};

$slim->post('/api/led/activate/:number', function ($number) use ($slim) {
    $ledService = new LedControlService();
    $command = $ledService->activateLed($number);
    echo $command;
});

$slim->post('/api/led/deactivate/:number', function ($number) use ($slim) {
    $ledService = new LedControlService();
    $command = $ledService->deactivateLed($number);
    echo $command;
});

$slim->get('/', function () use ($slim) {
    $slim->redirect('/start');
});

$slim->get('/start', $view('start'));   


// Make every angular.js
$slim->get('/js/:name.js', function ($name) use ($slim) {
    if (!file_exists(__DIR__ . '/pages/' . $name .'/angular.js')) {
        $slim->halt(404);
    }
    $slim->response->headers()->set('Content-Type', 'application/javascript');
    readfile(__DIR__ . '/pages/' . $name . '/angular.js');
});

$slim->run();
