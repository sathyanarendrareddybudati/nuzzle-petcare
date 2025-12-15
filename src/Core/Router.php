<?php
namespace App\Core;

class Router
{
    private array $routes = [];
    private $fallback;
    private array $middleware = [];

    public function get(string $pattern, $handler): self
    {
        $this->add('GET', $pattern, $handler);
        return $this;
    }

    public function post(string $pattern, $handler): self
    {
        $this->add('POST', $pattern, $handler);
        return $this;
    }

    public function middleware(string $middleware): self
    {
        $this->routes[count($this->routes) - 1]['middleware'] = $middleware;
        return $this;
    }

    public function fallback(callable $handler): void
    {
        $this->fallback = $handler;
    }

    public function dispatch(string $method, string $path): void
    {
        $path = rtrim($path, '/') ?: '/';
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['regex'], $path, $matches)) {
                if (isset($route['middleware'])) {
                    $middlewareClass = "App\\Middleware\\" . $route['middleware'];
                    if (class_exists($middlewareClass)) {
                        $middleware = new $middlewareClass();
                        $middleware->handle();
                    }
                }

                $params = [];
                foreach ($route['vars'] as $name) {
                    $params[$name] = $matches[$name] ?? null;
                }

                [$class, $action] = $route['handler'];
                $instance = new $class();
                $instance->$action(...array_values($params));
                return;
            }
        }

        if ($this->fallback) {
            call_user_func($this->fallback);
            return;
        }

        http_response_code(404);
        echo '404 Not Found';
    }

    private function add(string $method, string $pattern, $handler): void
    {
        [$regex, $vars] = $this->compile($pattern);
        $this->routes[] = [
            'method' => $method,
            'regex' => $regex,
            'vars' => $vars,
            'handler' => $handler,
        ];
    }

    private function compile(string $pattern): array
    {
        $vars = [];
        $regex = preg_replace_callback('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', function ($m) use (&$vars) {
            $vars[] = $m[1];
            return '(?P<' . $m[1] . '>[^/]+)';
        }, rtrim($pattern, '/') ?: '/');
        $regex = '#^' . ($regex ?: '/') . '$#';
        return [$regex, $vars];
    }
}
