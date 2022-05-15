<?php session_start();
class IndexController extends AbstractController
{

    public function index()
    {
        $userDAO = new UserDAO();
        $user = $userDAO->fetchall();

        $chevalDAO = new ChevalDAO();
        $cheval = $chevalDAO->fetchall();

        $coursDAO = new CoursDAO();
        $cours = $coursDAO->fetchall();

        if (isset($_COOKIE['sessionToken'])) {
            // Trouver ID du user connecté
            $IDloggedUser = $userDAO->fetchIdWhere('UserID', 'user', 'sessionToken', $_COOKIE['sessionToken']);
            // Récupérer toutes les infos du user connecté
            $loggedUser = $userDAO->fetch($IDloggedUser['UserID'], "UserID");
            // Trouver son role
            $_SESSION['roleLoggedUser'] = $loggedUser->role->nom;
            // Si role = useer on renvoie sur la page user
            if ($IDloggedUser && $_SESSION['roleLoggedUser'] == 'user') {
                include_once('../views/head.php');
                include_once('../views/accueil/accueilLogged.php');
                include_once('../views/foot.php');
            }
            // Si role = admin on renvoie sur la page admin
            elseif ($IDloggedUser && $_SESSION['roleLoggedUser'] == 'admin') {
                include_once('../views/head.php');
                include_once('../views/accueil/accueilLoggedAdmin.php');
                include_once('../views/foot.php');
            }
            // Si pas connecté on renvoie sur la page d'accueil
            else {

                //Si pour une raison le cookie est toujours dans le browser mais plus dans la BD

                unset($_COOKIE['sessionToken']);
                unset($_SESSION['roleLoggedUser']);
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
}
