<?php
namespace classes;

class Application
{
    private $controller;

    private function setApp(){
        $loadName = 'classes\Controllers\\';
        $url = explode('/', @$_GET['url'] ?? '');

        if ($url[0] == '') {
            $loadName .= 'Home';
        } else {
            $loadName .= ucfirst(strtolower($url[0]));
        }
    
        $loadName .= 'Controller';
        $load = str_replace('\\','/',$loadName);

        if (file_exists($load . '.php')) {
            $this->controller = new $loadName();
        } else {
            include('Views/pages/404.php');
            //echo $load . '.php';
            die();
        }
    }

    public function run(){
        $this->setApp();
        $this->controller->index();
    }
}
?>
