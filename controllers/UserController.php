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

        if (isset($_COOKIE['sessionToken'])){
            // PROBLEME SECU ????? QUELQU'UN QUI SET TOKEN POUR AVOIR ACCES A LA PAGE ----------------------
            $loggedUser = $userDAO->fetchIdWhere('UserID', 'user', 'sessionToken', $_COOKIE['sessionToken']);
            include('../views/head.php');
            include('../views/accueil/accueilLogged.php');
            include('../views/foot.php');
        }


        include('../views/head.php');
        include('../views/login/register.php');
        include('../views/foot.php');

    }

    public function store($UserID, $data)
    {
        $store = $this->dao->store($data);
        return $store;
    }

    public function login()
    {
        include('../views/head.php');
        include('../views/login/login.php');
        include('../views/foot.php');
    }

    public function register($id, $data)
    {
        var_dump($data);


        var_dump($_POST);
        //inserer en db le nouvel utilisateur
        if (!empty($data['prenom']) && !empty($data['nom']) && !empty($data['email']) && !empty($data['mdp'])) {
            $store = $this->store(false, $data);
            var_dump($store);
            if ($store === true) {
                $url = $data['route'] ? $data['route'] : '/';
                header("Location:{$url}");
            } else {
                var_dump('erreur store');
                $this->index();
            }
        } else {
            echo "Erreur register";
            $this->index();
        }
    }

}
