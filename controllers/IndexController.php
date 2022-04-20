<?php
class IndexController extends AbstractController{

    public function index () {
    
        include ('../views/head.php');
        include ('../views/accueil/accueil.php');
        include ('../views/foot.php');
    }


}
?>