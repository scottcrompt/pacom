
<?php session_start();
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
            // Trouver son role
            $_SESSION['roleLoggedUser'] = $loggedUser->role->nom;

            // Si role = admin on renvoie sur la page admin
            if ($IDloggedUser && $_SESSION['roleLoggedUser'] == 'admin') {
                if (isset($_GET['redirect'])) {
                    if ($_GET['redirect'] == "prop") {
                        $proprietaire = array();
                        foreach ($user as $users) {
                            if (sizeof($users->cheval) >= 1) {
                                array_push($proprietaire, $users);  // Propriétaires = utilisteurs qui ont des chevaux 
                            }
                        }

                        include_once('../views/head.php');
                        include_once('../views/proprietaire/proprietaireIndex.php');
                        include_once('../views/foot.php');
                    }
                } else {
                    include_once('../views/head.php');
                    include_once('../views/user/userIndex.php');
                    include_once('../views/foot.php');
                }
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

    public function store($UserID, $data)
    {
        $store = $this->dao->store($data);
        return ($store);
    }

    public function login($id, $data)
    {
        if (isset($_SESSION['roleLoggedUser']) || isset($_COOKIE['sessionToken'])) {
            $this->index();
        } else {
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
    }



    public function register($id, $data)
    {

        if (!empty($data)) {
            //inserer en db le nouvel utilisateur
            if (
                !empty($data['prenom']) && !empty($data['nom']) && !empty($data['email']) && !empty($data['mdp']) && !empty($data['mdp2']) && !empty($data['email2']) &&
                ($data['mdp']) == ($data['mdp2']) && ($data['email']) == ($data['email2'])
            ) {
                try {
                    $store = $this->store(false, $data);
                } catch (Exception $e) {
                    include_once('../views/head.php');
                    include_once('../views/error.php');
                    include_once('../views/foot.php');
                }
                if (empty($e)) {
                    if ($store == true) {
                        if (!isset($_SESSION['roleLoggedUser'])) {   // Pour register
                            $messageConfirmation = "Votre compte a bien été crée, un mail vous a été envoyé."; // Message confirmation
                        } elseif (isset($_SESSION['roleLoggedUser']) && $_SESSION['roleLoggedUser'] == 'admin') {  //Pour création d'utilisateur admin
                            $messageConfirmation = "L'utilisateur a bien été crée et un mail lui a été envoyé avec son mot de passe temporaire.";
                        }

                        $url = $data['route'] ? $data['route'] : '/';
                        header("Location:{$url}?message=" . $messageConfirmation);
                    }
                }
            } else {
                if (!isset($_SESSION['roleLoggedUser'])) {    //Quelque chose se passe mal register
                    $messageErreur = "Oups, quelque chose s'est mal passé."; // Message d'erreur
                    include_once('../views/head.php');
                    include_once('../views/login/register.php');
                    include_once('../views/foot.php');
                } elseif (isset($_SESSION['roleLoggedUser']) && $_SESSION['roleLoggedUser'] == 'admin') {   // Quelque chose se passe mal ajout de user admin
                    $this->create();
                }
            }
        } else {
            // Redirect si on veut simplement le formulaire (Register not logged)
            if (!isset($_SESSION['roleLoggedUser']) || !isset($_COOKIE['sessionToken'])) {  //Pour ne pas qu'un utilisateur loggé ai accès au formulaire register
                include_once('../views/head.php');
                include_once('../views/login/register.php');
                include_once('../views/foot.php');
            } else {
                $this->index();   //Redirection au cas où un utilisateur loggé essaye d'avoir accès au formulaire register
            }
        }
    }

    public function delete($data)
    {

        //Variable pour check si l'utilisateur connecté ne se supprime pas lui-même
        $userDAO = new UserDAO();
        $user = $userDAO->fetchall();
        $IDloggedUser = $userDAO->fetchIdWhere('UserID', 'user', 'sessionToken', $_COOKIE['sessionToken']);
        if ($data!= $IDloggedUser['UserID']) {   // Check si l'utilisateur connecté ne se supprime pas lui-même
            if ($_SESSION['roleLoggedUser'] == 'admin') {
                try {
                    $this->dao->delete($_POST);
                } catch (Exception $e) {
                    include_once('../views/head.php');
                    include_once('../views/error.php');
                    include_once('../views/foot.php');
                }
            } else {
                $this->index();
            }
            $messageConfirmation = 'Utilisateur supprimé';
            $url = $_POST['route'] ? $_POST['route'] : '/';
            header("Location:{$url}?message=" . $messageConfirmation);
        }
        else{
            $this->index();
        }
    }




    public function deleteToken()
    {
        if (isset($_COOKIE['sessionToken'])) {
            $this->dao->deleteToken('sessionToken', $_COOKIE['sessionToken']);
            unset($_COOKIE['sessionToken']);
            setcookie('sessionToken', '', time() - 3600, '/');
        }
        if (isset($_SESSION['roleLoggedUser'])) {
            unset($_SESSION['roleLoggedUser']);
            session_unset();
        }
        $_SERVER['REQUEST_URI'] = '/index.php';
        $this->index();
    }

    public function create()
    {

        if (isset($_SESSION['roleLoggedUser']) && $_SESSION['roleLoggedUser'] == "admin") {
            $roleDAO = new RoleDAO();
            $role = $roleDAO->fetchall();
            include_once('../views/head.php');
            include_once('../views/user/CRUD/userCreate.php');
            include_once('../views/foot.php');
        } else {
            $this->index();
        }
    }

    public function edit($id)
    {
        if ($_SESSION['roleLoggedUser'] == 'admin') {

            $user = $this->dao->fetch($id, "UserID");

            $roleDAO = new RoleDAO();
            $role = $roleDAO->fetchAll();

            include('../views/head.php');
            include('../views/user/CRUD/userEdit.php');
            include('../views/foot.php');
        } else {
            $this->index();
        }
    }

    public function update($id, $data)
    {
        try {
            $update = $this->dao->update($id, $data);
            var_dump($update);
        } catch (Exception $e) {
            include_once('../views/head.php');
            include_once('../views/error.php');
            include_once('../views/foot.php');
        }
        if (isset($update)) {
            if ($update == true) {
                $messageConfirmation = 'Utilisateur modifié';
                $url = $_POST['route'] ? $_POST['route'] : '/';
                header("Location:{$url}?message=" . $messageConfirmation);
            } else {
                include_once('../views/head.php');
                include_once('../views/error.php');
                include_once('../views/foot.php');
            }
        } else {
            include_once('../views/head.php');
            include_once('../views/error.php');
            include_once('../views/foot.php');
        }
    }
}
