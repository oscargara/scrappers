<?php

class Router {
    
    private $_request;
    private $_routes;
    private $_basepath;
    
    function __construct($routes, $basePath='/') {        
        $this->_routes  = $routes; 
        $this->_basepath = $basePath;
    }
    
    public function distpatch(Request $request){
        $this->_request = $request; 
        $fullPath = str_replace($this->_basepath, '', $this->_request->getPATH());
        
        list($path, ) = explode('?', $fullPath);

        $varName = array();
        
        foreach ($this->_routes as $route){

            if (preg_match($route['pattern'], $path, $m)){ 
                
                array_shift($m);             
                foreach ($m as $i=>$part){
                    $varName[$route['parts'][$i]] = $part;
                }
                $className = $route['class'].'Controller';
                
                $controller = new $className($request);                
                return $controller->$route['action']($varName);
            }
        }
        
        throw new Exception('no route for '.$path);
    }
}
