<?php

namespace Core;
class Router
{

    protected $routes = [];

    protected $params = [];

  

    public function add($route, $params=[])
    {
      
        $route = preg_replace('/\//','\\/',$route);
        $route = preg_replace('/\{([a-z]+)\}/','(?<\1>[a-z-]+)',$route);
        $route = preg_replace('/\{([a-z]+):.+\}/','(?<\1>\d+)',$route);
        $route = '/^'.$route.'$/i';
        $this->routes[$route] = $params; 

    }

    public function match($url)
    {

        foreach($this->routes as $route=>$params)
        {
            if(preg_match($route, $url, $matches))
            {
                foreach($matches as $key=>$match)
                {
                    if(is_string($key))
                    {
                       $params[$key] = $match;
                    }
                }
                $this->params = $params;
              
                return true;
            }
        }
        return false;

    }

    public function dispatch($url)
    {
        $url = $this->removeQueryStringVariables($url);
        if($this->match($url))
        {
           
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            // $controller = "App\Controllers\\$controller";
            $controller = $this->getNamespace().$controller;

            if(class_exists($controller))
            {
                $controller_object = new $controller($this->params);
                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if(is_callable([$controller_object,$action]))
                { 
                    $controller_object->$action();
                } else{
                   throw new \Exception("Method $action (in controller $controller) not found");
                }

            } else{
                throw new \Exception("Conroller class $controller not found");
            }

        } else{
            throw new \Exception("URL doesn't exist",404);
        }
    }

    protected function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }
    /**
     * Convert the string with hyphens to camelCase,
     * e.g. add-new => addNew
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    protected function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }
    protected function removeQueryStringVariables($url)
    {
        $parts = explode('&',$url);
        return $parts[0];
    }
    public function getRoutes()
    {
        return $this->routes;
    }

    protected function getNamespace()
    {
        $namespace = 'App\Controllers\\';

        if(array_key_exists('namespace',$this->params))
        {
            $namespace .= $this->params['namespace'].'\\';
        }
        return $namespace;
    }
    public function getParams()
    {
        return $this->params;
    }
}
