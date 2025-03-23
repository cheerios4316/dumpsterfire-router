<?php

namespace DumpsterfireRouter\Interfaces;

interface RouterInterface
{
    public function getControllerFromRoute(string $route): ControllerInterface;

    /**
     * @param class-string<ControllerInterface> $path
     * @param string $controllerInterface
     * @return void
     */
    public function registerRoute(string $path, string $controllerInterface, array &$routes = []): self;

    public function addRouter(RouterInterface $router): self;
}