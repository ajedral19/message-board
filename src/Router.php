<?php
class Router
{
    private $connection;
    private $routes = [];
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    private function call(string $method, string $uri = null, ?string $controller = null, ?string $action = null, ?string $view = null, ?array $options = null)
    {    
        $params = $_SERVER['QUERY_STRING'];
        $q =  (explode('&', $params));
        $queies = [];

        if (!empty($params) && isset($params)) {
            foreach ($q as $key => $value) {
                $v = explode('=', $value);
                array_push($queies, [$v[0] => $v[1]]);
            }
        }

        if (preg_match("/!?\/+\w+(.*$)/", $_SERVER['REQUEST_URI'], $matches)) {
            $url = preg_replace("/=(\w+)/", '', $matches[1]);
            if (strtolower($uri) === $url) {
                $controller::$action($view, $this->connection);
                // return $view(Utils::sendMsg('SUCCESS'));
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
     * @param ?array
     */
    public function route(string $method, string $uri, string $view, array $module, ?array $options = null)
    {
        // validate method
        $methods = ["post", "get", "put", "patch", "delete"];
        $method = strtolower($method);
        if (!in_array($method, $methods, true))
            return;

        // validate url
        $arr = [
            "method" => strtoupper($method),
            "uri" => $uri,
            "view" => $view,
            "module" => $module,
            "options" => [...$options]
        ];
        array_push($this->routes, $arr);
        // echo json_encode($this->routes);
    }

    public function serve(){
        foreach ($this->routes as $index => $route) {
            preg_match("/!?\/+\w+(.*$)/", $_SERVER['REQUEST_URI'], $matches);
            $uri = preg_replace("/=\w+/", '', $matches[1]);
            if($route['uri'] == $uri && $route['method'] == $_SERVER['REQUEST_METHOD']){
                $this->call($route['method'], $route['uri'], $route['module']['controller'], $route['module']['action'], $route['view']);
            }
        }
    }
}
