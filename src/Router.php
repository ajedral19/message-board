<?php

define('METHODS', ["get", "head", "post", "put", "delete", "connect", "options", "trace", "patch"]);
class Router
{
    private $routes = [];

    private function call(string $uri = null, ?string $controller = null, ?string $action = null, ?string $view = null)
    {
        $query = $_SERVER['QUERY_STRING'];
        $params =  (explode('&', $query));
        $paramsArr = [];

        if (!empty($query) && isset($query)) {
            foreach ($params as $value) {
                $v = explode('=', $value);
                array_push($paramsArr, [$v[0] => $v[1]]);
            }
        }

        if (preg_match("/!?\/+\w+(.*$)/", $_SERVER['REQUEST_URI'], $matches)) {
            $url = preg_replace("/=(\w+)/", '', $matches[1]);
            if (strtolower($uri) === $url) {
                $controller::$action($view);
            } else {
                echo "404";
                return;
            }
        }
    }

    /**
     * @param string method
     * @param string uri
     * @param string view function
     * @param array module ["controller" => "", "action" => ""]
     */
    public function route(string $method, string $uri, string $view, ?array $module = null)
    {
        $methods = METHODS;
        $method = strtolower($method);
        if (!in_array($method, $methods, true))
            return;

        // validate url
        $arr = [
            "method" => strtoupper($method),
            "uri" => $uri,
            "view" => $view,
            "module" => $module,
        ];
        array_push($this->routes, $arr);
        // echo json_encode($this->routes);
    }

    private static function authorize()
    {
        $secret = "secret key";
        $headers = getallheaders();
        echo json_encode($headers);
    }

    public function serve(bool $authorize_access = false)
    {
        $authorized = true;

        if ($authorize_access) {
            self::authorize();
        }

        if (!$authorized)
            return Error('Unauthorized access', 403);

        foreach ($this->routes as $route) {
            preg_match("/!?\/+\w+(.*$)/", $_SERVER['REQUEST_URI'], $matches);
            $uri = preg_replace("/=\w+/", '', $matches[1]);
            if ($route['uri'] == $uri && $route['method'] == $_SERVER['REQUEST_METHOD']) {
                $this->call($route['uri'], $route['module']['controller'], $route['module']['action'], $route['view']);
                return;
            }
        }
    }
}
