<?php
class UserController extends AbstractController
{
    public function __construct()
    {
        $this->dao = new UserDAO();
    }

    public function index()
    {

        $userDAO = new UserDAO();
        $user = $userDAO->fetchall();

        if (isset($_COOKIE['sessionToken'])) {
            // Trouver ID du user connecté
            $IDloggedUser = $userDAO->fetchIdWhere('UserID', 'user', 'sessionToken', $_COOKIE['sessionToken']);
            // Récupérer toutes les infos du user connecté
            $loggedUser = $userDAO->fetch($IDloggedUser['UserID'], "UserID");
            var_dump($loggedUser);
            // Trouver son role
            $roleLoggedUser = $loggedUser->role->nom;
            // Si role = useer on renvoie sur la page user
            if ($IDloggedUser && $roleLoggedUser == 'user') {
                //On renvoie le role à la vue pour afficher le header correcte
                $roleLoggedUser = $loggedUser->role->nom;
                include_once('../views/head.php');
                include_once('../views/accueil/accueilLogged.php');
                include_once('../views/foot.php');
            }
            // Si role = admin on renvoie sur la page admin
            elseif ($IDloggedUser && $roleLoggedUser == 'admin') {
                //On renvoie le role à la vue pour afficher le header correcte
                $roleLoggedUser = $loggedUser->role->nom;
                include_once('../views/head.php');
                include_once('../views/accueil/accueilLoggedAdmin.php');
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

    public function store($UserID, $data)
    {
        $store = $this->dao->store($data);
        return $store;
    }

    public function login($id, $data)
    {

        if (!empty($_POST)) {
            $user = $this->dao->verify($data);
            if ($user) {
                $url = $data['route'] ? $data['route'] : '/';
                header("Location:{$url}");
            } else {
                $messageErreur = "Nom d'utilisateur ou mot de passe incorrect";
                include_once('../views/head.php');
                include_once('../views/login/login.php');
                include_once('../views/foot.php');
            }
        } else {
            include_once('../views/head.php');
            include_once('../views/login/login.php');
            include_once('../views/foot.php');
        }
    }



    public function register($id, $data)
    {
        var_dump($data);

        if (!empty($data)) {
            //inserer en db le nouvel utilisateur
            if (
                !empty($data['prenom']) && !empty($data['nom']) && !empty($data['email']) && !empty($data['mdp']) && !empty($data['mdp2']) && !empty($data['email2']) &&
                ($data['mdp']) == ($data['mdp2']) && ($data['email']) == ($data['email2'])
            ) {
                $store = $this->store(false, $data);
                if ($store === true) {
                    $messageConfirmation = "Votre compte a bien été crée, un mail vous a été envoyé."; // Message confirmation
                    $url = $data['route'] ? $data['route'] : '/';
                    header("Location:{$url}?message=" . $messageConfirmation);
                }
            } else {
                $messageErreur = "Oups, quelque chose s'est mal passé."; // Message d'erreur
                include_once('../views/head.php');
                include_once('../views/login/register.php');
                include_once('../views/foot.php');
            }
        } else {
            include_once('../views/head.php');
            include_once('../views/login/register.php');
            include_once('../views/foot.php');
        }
    }

    public function deleteToken()
    {
        if (isset($_COOKIE['sessionToken'])) {
            $this->dao->deleteToken('sessionToken', $_COOKIE['sessionToken']);
            unset($_COOKIE['sessionToken']);
            setcookie('sessionToken', '', time() - 3600, '/');
        }
        $_SERVER['REQUEST_URI'] = '/index.php';
        $this->index();
    }
}
