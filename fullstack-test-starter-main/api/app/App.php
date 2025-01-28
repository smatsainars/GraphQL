<?php

namespace App;

require_once __DIR__ . '/../vendor/autoload.php';


use App\Controllers\GraphQL;
use Doctrine\ORM\EntityManager;


class App {
    public static function run(): void {
        $entityManager = self::createEntityManager(); // Your existing method

        $dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) use ($entityManager) {
            $r->post('/graphql', function() use ($entityManager) {
                GraphQL::handle($entityManager); // Pass EntityManager here
            });
        });

        // ... rest of your routing logic
    }
}


$dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) {
    $r->post('/graphql', [GraphQL::class, 'handle']);
});

$routeInfo = $dispatcher->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);

switch ($routeInfo[0]) {
    case \FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case \FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        echo $handler($vars);
        break;
}