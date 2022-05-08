<?php
class ChevalController extends AbstractController
{
    public function __construct()
    {
        $this->dao = new ChevalDAO();
    }

    public function index()
    {
        $userDAO = new UserDAO();
        $user = $userDAO->fetchall();
        $chevalDAO = new ChevalDAO();
        $cheval = $chevalDAO->fetchall();

    
        if (isset($_COOKIE['sessionToken'])) {
            // Trouver ID du user connecté
            $IDloggedUser = $userDAO->fetchIdWhere('UserID', 'user', 'sessionToken', $_COOKIE['sessionToken']);
            // Récupérer toutes les infos du user connecté
            $loggedUser = $userDAO->fetch($IDloggedUser['UserID'], "UserID");
         
            // Trouver son role
            $roleLoggedUser = $loggedUser->role->nom;
            
            // Si role = admin on renvoie sur la page admin
            if ($IDloggedUser && $roleLoggedUser == 'admin') {
                include_once('../views/head.php');
                include_once('../views/cheval/chevalIndex.php');
                include_once('../views/foot.php');
            }
            // Si pas connecté on renvoie sur la page d'accueil
            else {
                //Si pour une raison le cookie est toujours dans le browser mais plus dans la BD
                unset($_COOKIE['sessionToken']);
                setcookie('sessionToken', '', time() - 3600, '/');
                include_once('../views/head.php');
                include_once('../views/accueil/accueil.php');
                include_once('../views/foot.php');
            }
        } else {
            include_once('../views/head.php');
            include_once('../views/accueil/accueil.php');
            include_once('../views/foot.php');
        }
    }

    public function delete ($data) {
        try{
        $this->dao->delete($data);
        var_dump($data);
        var_dump($_POST);
        }
        catch(Exception $e){
            include_once('../views/head.php');
            include_once('../views/error.php');
            include_once('../views/foot.php');
        }
        $this->index();
    }
}