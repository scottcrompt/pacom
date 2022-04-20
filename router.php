<?php

class Router {
    
    private $get;
    private $post;
    private $controllers;
    private $data;
    private $request;
    private $actions;
    
    public function __construct() {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->actions = ['create', 'edit', 'delete', 'show', 'update', 'store', 'index', 'login', 'register', 'deleteToken'];
        $this->controllers = ['index' => 'IndexController', 'user' => 'UserController'];
        $this->request = array();
        $this->data = $this->parseURI($_SERVER['REQUEST_URI']);
        $this->dispatch();
        $this->run();
    }
    
    private function parseURI ($server_uri) {
        
        if (strpos( $server_uri, "?")) {
            $server_uri = strstr($server_uri, '?', true);
        }
        
        $server_uri = explode("/", substr($server_uri, 1));
        return $server_uri;
    }
    
    private function dispatch () {
        //verifier si on a 1 controller, 1 action et 1 id
        if (!array_key_exists($this->data[0], $this->controllers)) {
            $this->data[0] = 'index';
        }
        $this->request['controller'] = $this->controllers[$this->data[0]];
        
        //detecter l'action => voir si on en a trouvé une, ou pas, si celle qu'on a trouvé est autorisée
        if (count($this->data) >= 2 && $this->data[1]) {
            if(!in_array($this->data[1], $this->actions)) {
                echo "ERR : ACTION NOT FOUND";
                die;
            }
        
            $this->request['action'] = $this->data[1];
        } else {
            $this->request['action'] = "index";
        }
        
        //detection de l'id
        if (count($this->data) >= 3 && $this->data[2]) { 
            $this->request['id'] = $this->data[2];
        } else {
            $this->request['id'] = false;
        }
        
        //detection get/post 
        if ($this->post && count($this->post)) {
            $this->request['method'] = 'post';
        } else {
            $this->request['method'] = 'get';
        }
        
    }
    
    private function run () {
        //instancier 1 controller
        $this->controller_instance = new $this->request['controller'];
        
        $data = $this->get;
        if($this->request['method'] == 'post')  {
            $data = $this->post;
        }
        
        //appeller la méthode du controller
        if (method_exists($this->controller_instance, $this->request['action'])) {
            $this->controller_instance->{$this->request['action']}($this->request['id'], $data);
        } else {
            echo "Methode n'existe pas sur ce controlleur";
        }
        
        
    }
} ?>