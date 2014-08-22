<?php

class Request {

    private $_get;
    private $_post;
    private $_cookie;
    private $_header;
    private $_path;    
    
    function __construct() {
        $this->init();
    }
    function init(){
        $this->_get = $_GET;
        $this->_post = $_POST;
        $this->_cookie = $_COOKIE;
        $this->_path = $_SERVER['REQUEST_URI'];       
        $this->_header = getallheaders();        
    }
    
    public function getGET(){
        return $this->_get;
    }
    public function getPOST(){
        return $this->_post;
    }
    public function getCOOKIE(){
        return $this->_cookie;
    }
    public function getHEADER(){
        return $this->_header;
    }
    public function getPATH(){
        return $this->_path;
    }
    
    
}
