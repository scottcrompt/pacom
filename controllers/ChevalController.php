<?php session_start();
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
            $_SESSION['roleLoggedUser'] = $loggedUser->role->nom;
            // Si role = useer on renvoie sur la page user
            if ($IDloggedUser && $_SESSION['roleLoggedUser'] == 'admin') {
                include_once('../views/head.php');
                include_once('../views/admin/cheval/chevalIndex.php');
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

    public function register($id, $data)
    {
        if (!empty($data)) {
            //inserer en db le nouveau cheval
            if (!empty($data['nom']) && !empty($data['user'])) {
                try {
                    $store = $this->store(false, $data);
                } catch (Exception $e) {   // Si erreur dans store
                    include_once('../views/head.php');
                    include_once('../views/error.php');
                    include_once('../views/foot.php');
                }
                if ($store === true) {
                    $messageConfirmation = "Cheval ajouté"; // Message confirmation
                    $url = $data['route'] ? $data['route'] : '/';
                    header("Location:{$url}?message=" . $messageConfirmation);
                }
            } else {
                $messageErreur = "Oups, quelque chose s'est mal passé."; // Message d'erreur
                include_once('../views/head.php');
                include_once('../views/admin/cheval/chevalIndex.php');
                include_once('../views/foot.php');
            }
        } else {
            $messageErreur = "Oups, quelque chose s'est mal passé."; // Message d'erreur
            include_once('../views/head.php');
            include_once('../views/admin/cheval/chevalIndex.php');
            include_once('../views/foot.php');
        }
    }

    public function store($id, $data)
    {
        $store = $this->dao->store($data);
        return $store;
    }

    public function delete($data)
    {
        if (isset($_SESSION['roleLoggedUser']) && isset($_COOKIE['sessionToken'])) {
            if ($_SESSION['roleLoggedUser'] == 'admin') {
                try {
                    $this->dao->delete($_POST);
                } catch (Exception $e) {
                    include_once('../views/head.php');
                    include_once('../views/error.php');
                    include_once('../views/foot.php');
                }
                if (empty($e)) {
                    $messageConfirmation = 'Cheval supprimé';
                    $url = $_POST['route'] ? $_POST['route'] : '/';
                    header("Location:{$url}?message=" . $messageConfirmation);
                }
            } else {
                $this->index();
            }
        } else {
            $this->index();
        }
    }

    public function edit($id)
    {
        if (isset($_SESSION['roleLoggedUser']) && isset($_COOKIE['sessionToken'])) {
            if ($_SESSION['roleLoggedUser'] == 'admin') {
                $cheval = $this->dao->fetch($id, "ChevalID");

                $userDAO = new UserDAO();
                $user = $userDAO->fetchAll();
                if ($cheval) {
                    include('../views/head.php');
                    include('../views/admin/cheval/CRUD/chevalEdit.php');
                    include('../views/foot.php');
                }
            } else {
                $this->index();
            }
        } else {
            $this->index();
        }
    }

    public function update($id, $data)
    {
        try {
            $this->dao->update($id, $data);
        } catch (Exception $e) {
            include_once('../views/head.php');
            include_once('../views/error.php');
            include_once('../views/foot.php');
        }
        if (empty($e)) {
            $messageConfirmation = 'Cheval modifié';
            $url = $_POST['route'] ? $_POST['route'] : '/';
            header("Location:{$url}?message=" . $messageConfirmation);
        }
    }
}
