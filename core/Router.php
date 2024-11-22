<?php
// core/Router.php

class Router {
    private $routes = [];

    // Register a GET route
    public function get($uri, $handler) {
        $this->addRoute('GET', $uri, $handler);
        return $this;  // Enable method chaining
    }

    // Register a POST route
    public function post($uri, $handler) {
        $this->addRoute('POST', $uri, $handler);
        return $this;  // Enable method chaining
    }

    // Add a route to the routes array
    private function addRoute($method, $uri, $handler) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'uri' => $uri,
            'handler' => $handler
        ];
    }

    // Dispatch the request to the appropriate handler
    public function dispatch($method, $uri) {
        echo "calling dispacther";
        foreach ($this->routes as $route) {
            if ($this->matchRoute($route, $method, $uri)) {
                return $this->callHandler($route['handler']);
            }
        }

        // Route not found, show 404
        http_response_code(404);
        echo "404 Not Found";
    }

    // Check if a route matches the current method and URI
    private function matchRoute($route, $method, $uri) {
        return $route['method'] === strtoupper($method) && $route['uri'] === $uri;
    }

    // Call the appropriate handler (controller and method or closure)
    private function callHandler($handler) {
        echo "calling handler";
        if (is_callable($handler)) {
            // If it's a closure (anonymous function), call it directly
            return call_user_func($handler);
        }

        if (is_string($handler)) {
            // The handler is in "Controller@Method" format
            list($controller, $method) = explode('@', $handler);
            $controller = "HomeController"; // For simplicity, you can modify this for full namespace support

            if (class_exists($controller) && method_exists($controller, $method)) {
                return (new $controller)->$method();
            }
        }

        throw new Exception("Handler not found.");
    }
}
