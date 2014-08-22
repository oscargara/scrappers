<?php

namespace TemplateEngine;

class View {

    private $_contentPath;

    public function __construct($contentPath = ''){
        $this->_contentPath = $contentPath;
    }

    function render($template, $data){
        ob_start();
        include $this->_contentPath .$template. '.php';
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}

