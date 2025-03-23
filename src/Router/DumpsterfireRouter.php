<?php

namespace DumpsterfireRouter\Router;

use DumpsterfireBase\Container\Container;
use DumpsterfireRouter\Exceptions\RoutingException;
use DumpsterfireRouter\Interfaces\ControllerInterface;
use DumpsterfireRouter\Interfaces\RouterInterface;
use Exception;
use Throwable;

class DumpsterfireRouter implements RouterInterface
{
    /**
     * @var RouterInterface[];
     */
    protected static array $routers = [];

    /**
     * 
     * @var array<string, ControllerInterface> $routes;
     */
    protected static array $routes = [];

    public function getControllerFromRoute(string $route): ControllerInterface
    {
        try {
            $controller = $this->matchRoute($route);
        } catch (Throwable $e) {
            $this->show404();
        }

        return $controller;
    }

    public function registerRoute(string $path, string $controllerInterface, array &$routes = []): RouterInterface
    {
        if (empty($routes)) {
            $routes = &self::$routes;
        }

        if(isset($routes[$path])) {
            throw new RoutingException('Routing rule "' . $path . '" is already defined.');
        }

        $routes[$path] = $controllerInterface;

        return $this;
    }

    public function addRouter(RouterInterface $router): self
    {
        self::$routers[$router::class] = $router;
        return $this;
    }

    public function getRouters(): array
    {
        return self::$routers;
    }

    public function getRoutes(): array
    {
        $routes = [...self::$routes];
        foreach(self::$routers as $router) {
            $routes = [
                ...$routes,
                $router->getRoutes()
            ];
        }

        return $routes;
    }

    protected function matchRoute(string $route): ControllerInterface
    {
        $routes = $this->getRoutes();

        foreach ($routes as $path => $controller) {
            $pattern = '/' . preg_quote($path, '/') . '/';

            preg_match($pattern, $route, $matches);

            if (!empty($matches) && is_array($matches) && !empty($matches[0])) {
                return Container::getInstance()->create($controller);
            }
        }

        throw new Exception('Controller not found for route ' . $route);
    }

    public function show404(): void
    {
        die('implement 404 page');
    }
}