<?php
class IndexController extends AbstractController{

    public function index () {
        $userDAO = new userDAO();
        $user = $userDAO->fetchall();
        var_dump($user);
        if (isset($_COOKIE['sessionToken'])) {
            $IDloggedUser = $userDAO->fetchIdWhere('UserID', 'user', 'sessionToken', $_COOKIE['sessionToken']);
            
            if ($IDloggedUser) {
                include_once('../views/head.php');
                include_once('../views/accueil/accueilLogged.php');
                include_once('../views/foot.php');
            } else {

                //Si pour une raison le cookie est toujours dans le browser mais plus dans la BD

                unset($_COOKIE['sessionToken']);
                setcookie('sessionToken', '', time() - 3600, '/');
                include_once('../views/head.php');
                include_once('../views/accueil/accueil.php');
                include_once('../views/foot.php');
            }
        }
        else {
        include_once('../views/head.php');
        include_once('../views/accueil/accueil.php');
        include_once('../views/foot.php');
        }
    


}
}
?>