<?php
namespace App\Core;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => [],
    ];
    private $fallback;

    public function get(string $pattern, $handler): void { $this->add('GET', $pattern, $handler); }
    public function post(string $pattern, $handler): void { $this->add('POST', $pattern, $handler); }

    public function fallback(callable $handler): void { $this->fallback = $handler; }

    public function dispatch(string $method, string $path): void
    {
        $routes = $this->routes[$method] ?? [];
        foreach ($routes as [$regex, $vars, $handler]) {
            if (preg_match($regex, $path, $matches)) {
                $params = [];
                foreach ($vars as $name) {
                    $params[$name] = $matches[$name] ?? null;
                }
                if (is_array($handler) && count($handler) === 2) {
                    [$class, $action] = $handler;
                    $instance = new $class();
                    $instance->$action(...array_values($params));
                    return;
                }
                if (is_callable($handler)) {
                    call_user_func_array($handler, array_values($params));
                    return;
                }
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
        $this->routes[$method][] = [$regex, $vars, $handler];
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
