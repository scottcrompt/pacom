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
                //On renvoie le role à la vue pour afficher le header correcte
                include_once('../views/head.php');
                include_once('../views/cours/coursIndex.php');
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
            include_once('../views/cours/CRUD/coursCreate.php');
            include_once('../views/foot.php');
        } else {
            $this->index();
        }
    }

    public function register($id, $data)
    {
        if (!empty($data)) {
            //inserer en db le nouveau cours
            if (!empty($data['nom']) && !empty($data['user'])) {
                $store = $this->store(false, $data);
                var_dump($store);
                if ($store === true) {
                    echo"YO";
                    $messageConfirmation = "Cours ajouté"; // Message confirmation
                    $url = $data['route'] ? $data['route'] : '/';
                    header("Location:{$url}?message=" .$messageConfirmation);
                }
            } else {
                $messageErreur = "Oups, quelque chose s'est mal passé."; // Message d'erreur
                include_once('../views/head.php');
                include_once('../views/cheval/chevalIndex.php');
                include_once('../views/foot.php');
            }
        } else {
            $messageErreur = "Oups, quelque chose s'est mal passé."; // Message d'erreur
            include_once('../views/head.php');
            include_once('../views/cheval/chevalIndex.php');
            include_once('../views/foot.php');
        }
    }




}
?>