<?php session_start();
class CoursController extends AbstractController
{
    public function __construct()
    {
        $this->dao = new CoursDAO();
    }

    public function index()
    {

        $userDAO = new UserDAO();
        $user = $userDAO->fetchall();

        $coursDAO = new CoursDAO();
        $cours = $coursDAO->fetchall();

        if (isset($_COOKIE['sessionToken'])) {
            // Trouver ID du user connecté
            $IDloggedUser = $userDAO->fetchIdWhere('UserID', 'user', 'sessionToken', $_COOKIE['sessionToken']);
            // Récupérer toutes les infos du user connecté
            $loggedUser = $userDAO->fetch($IDloggedUser['UserID'], "UserID");
            // Trouver son role
            $_SESSION['roleLoggedUser'] = $loggedUser->role->nom;

            // Si role = admin on renvoie sur la page admin
            if ($IDloggedUser && $_SESSION['roleLoggedUser'] == 'admin') {
                include_once('../views/head.php');
                include_once('../views/admin/cours/coursIndex.php');
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

    public function create()
    {

        if (isset($_SESSION['roleLoggedUser']) && $_SESSION['roleLoggedUser'] == "admin") {
            $roleDAO = new RoleDAO();
            $role = $roleDAO->fetchall();
            include_once('../views/head.php');
            include_once('../views/admin/cours/CRUD/coursCreate.php');
            include_once('../views/foot.php');
        } else {
            $this->index();
        }
    }

    public function store($id, $data)
    {
        $store = $this->dao->store($data);
        return $store;
    }

    public function register($id, $data)
    {
        if (!empty($data)) {
            //inserer en db le nouveau cours
            if (!empty($data['date']) && !empty($data['time']) && !empty($data['place']) && !empty($data['prix']) && !empty($data['ecurie'])) {

                // Il faut changer le format de la date pour la stocker dans la DB
                $newDateFormat = date("Y-m-d", strtotime($data['date']));
                $newTimeFormat = date("H:i:s", strtotime($data['time']));
                $data['date'] = $newDateFormat;
                $data['time'] = $newTimeFormat;
                try {
                    $store = $this->store(false, $data);
                } catch (Exception $e) {  // Si erreur dans store
                    include_once('../views/head.php');
                    include_once('../views/error.php');
                    include_once('../views/foot.php');
                }
                /*
                if ($store === true && empty($e)) {
                    $messageConfirmation = "Cours ajouté"; // Message confirmation
                    $url = $data['route'] ? $data['route'] : '/';
                    header("Location:{$url}?message=" . $messageConfirmation);
                }
                */
            } else {

                $messageErreur = "Oups, quelque chose s'est mal passé."; // Message d'erreur
                include_once('../views/head.php');
                include_once('../views/admin/cours/coursIndex.php');
                include_once('../views/foot.php');
            }
        } else {
            $messageErreur = "Oups, quelque chose s'est mal passé."; // Message d'erreur
            include_once('../views/head.php');
            include_once('../views/admin/cours/coursIndex.php');
            include_once('../views/foot.php');
        }
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
                    $messageConfirmation = 'Cours supprimé';
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
                $cours = $this->dao->fetch($id, "CoursID");
                // Changer format datetime pour affichage par défaut dans formulaire Edit
                $newDateFormat = date("d-m-Y", strtotime($cours->CoursDateTime));  
                $newTimeFormat = date("H:i", strtotime($cours->CoursDateTime));
                if ($cours) {
                    include('../views/head.php');
                    include('../views/admin/cours/CRUD/coursEdit.php');
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
        if (!empty($data['date']) &&!empty($data['time']) && !empty($data['place'])&& !empty($data['prix'])&& !empty($data['route'])&& !empty($data['ecurie'])) {
           // Il faut changer le format de la date pour la stocker dans la DB
           $newDateFormat = date("Y-m-d", strtotime($data['date']));
           $newTimeFormat = date("H:i:s", strtotime($data['time']));
           $data['date'] = $newDateFormat;
           $data['time'] = $newTimeFormat;
        try {
            $this->dao->update($id, $data);
        } catch (Exception $e) {
            include_once('../views/head.php');
            include_once('../views/error.php');
            include_once('../views/foot.php');
        }
        if (empty($e)) {
            $messageConfirmation = 'Cours modifié';
            $url = $_POST['route'] ? $_POST['route'] : '/';
            header("Location:{$url}?message=" . $messageConfirmation);
        }
    }
    else{
        $this->index();
    }
    }
}
