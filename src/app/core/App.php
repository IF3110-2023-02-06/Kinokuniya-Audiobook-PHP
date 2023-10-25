<?php

class App
{
    // Below is how the URL is parsed:
    // public/<controller_name>/<method_name>/:<parameters_list>
    protected $controller;
    protected $method;
    protected $params;

    public function __construct()
    {
        // By default, use NotFoundController to handle unknown URL
        require_once __DIR__ . '/../controllers/NotFoundController.php';
        $this->controller = new NotFoundController();
        $this->method = 'index';

        // 'Explode' URL such that [0] is controller, [1] is method, and the rest are parameters
        $url = $this->parseURL();

        // Check if controller file exists: if yes, use that controller; if not, use NotFoundController
        $controllerPart = $url[0] ?? null;
        if (isset($controllerPart) && file_exists(__DIR__ . '/../controllers/' . $controllerPart . 'Controller.php')) {
            require_once __DIR__ . '/../controllers/' . $controllerPart . 'Controller.php';
            $controllerClass = $controllerPart . 'Controller';
            $this->controller = new $controllerClass();
        }
        unset($url[0]);

        // Check if method exists: if yes, use that method; if not, use index method
        $methodPart = $url[1] ?? null;
        if (isset($methodPart) && method_exists($this->controller, $methodPart)) {
            $this->method = $methodPart;
        }
        unset($url[1]);

        // Check if there are parameters: if yes, use those parameters; if not, use empty array
        if (!empty($url)) {
            $this->params = array_values($url);
        } else {
            $this->params = [];
        }

        // Call the controller and pass the parameters
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseURL()
    {
        
        // 'Explode' URL such that [0] is controller, [1] is method, and the rest are parameters
        if (isset($_SERVER['REQUEST_URI'])) {
            $url = trim($_SERVER['REQUEST_URI'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            // Shift the array to the left by 1 to remove the 'public' folder
            array_shift($url);

            return $url;
        }
    }
}