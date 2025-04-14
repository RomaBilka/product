<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require __DIR__ . '/../vendor/autoload.php';

use FastRoute\RouteCollector;
use Illuminate\Http\Response;
use function FastRoute\simpleDispatcher;
use App\Controllers\ProductController;
use Symfony\Component\Validator\Validation;

$app = require_once __DIR__.'/../bootstrap/bootstrap.php';

$dispatcher = simpleDispatcher(function (RouteCollector $r) {
    $r->addGroup('/products', function (RouteCollector $r) {
        $r->addRoute('POST', '', [ProductController::class, 'create']);
        $r->addRoute('GET', '/{id}', [ProductController::class, 'show']);
        $r->addRoute('PATCH', '/{id}', [ProductController::class, 'update']);
        $r->addRoute('DELETE', '/{id}', [ProductController::class, 'delete']);
        $r->addRoute('GET', '', [ProductController::class, 'list']);
    });
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed', 'allowed' => $allowedMethods]);
        break;

    case FastRoute\Dispatcher::FOUND:
        [$class, $method] = $routeInfo[1];

        $productRepository = new \App\Repositories\ProductRepository();
        $categoryRepository = new \App\Repositories\CategoryRepository();
        $productService = new \App\Services\ProductService($productRepository, $categoryRepository);
        $product = new ProductController($productService);
        $request = Illuminate\Http\Request::capture();
        $request->mergeIfMissing($routeInfo[2]);
        $response = $product->$method($request);
        $response->send();

        break;
}
