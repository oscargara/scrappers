<?php

namespace TemplateEngine;

class Layout {

    private $_template;
    private $_zones;
    private $_contentPath;

    function __construct($template, $contentPath = '') {
        $this->_template = $template;
        $this->_contentPath = $contentPath;
        $this->_zones = array();
    }

    public function addZone($zoneName, $templateView, $data) {
        
        if ($templateView == ''){
            $this->_zones[$zoneName] = $data ;
        }else{
            $this->_zones[$zoneName] = $this->renderZone($templateView, $data) ;
        }
    }
    
    public function render(){
        $zones = $this->_zones;
        ob_start();
        include $this->_contentPath . $this->_template. '.php';
        $content = ob_get_contents();
        ob_end_clean(); 
        return $content;
    }

    public function renderZone($templateView, $data){
        ob_start();
        require $this->_contentPath . '/' . $templateView . '.php';
        $content = ob_get_contents();
        ob_end_clean();
        return $content ;
    }

}
