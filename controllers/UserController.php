<?php
class UserController extends AbstractController {

public function index () {
    include ('../views/head.php');
    include ('../views/accueil/accueilLogged.php');
    include ('../views/foot.php');
    }

public function login () {
    include ('../views/head.php');
    include ('../views/login/login.php');
    include ('../views/foot.php');
    }

public function register () {
    include ('../views/head.php');
    include ('../views/login/register.php');
    include ('../views/foot.php');
    }
}

?>