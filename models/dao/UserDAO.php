<?php
class UserDAO extends AbstractDAO
{
    public function __construct(){
        parent::__construct('user');
    }


    public function create ($result) {
        return new User(
            !empty($result['UserID']) ? $result['UserID'] : 0,
            $result['UserPrenom'],
            $result['UserNom'],
            $result['UserEmail'],
            $result['UserMdp'],
        );
    }   
    public function deepcreate ($result) {
        return new User(
            !empty($result['id']) ? $result['id'] : 0,
            $result['UserPrenom'],
            $result['UserNom'],
            $result['UserEmail'],
            $result['UserMdp'],
            //$this->equipe($result['id']),
            //$this->matchs($result['id'])   ------------------------------
        );
    }


    public function store ($data) {
        if (empty($data['nom']) || empty($data['prenom']) || empty($data['email']) || empty($data['mdp'])) {
            var_dump('veuillez renseigner tous les éléments');
            return false;
        }
        
        $User = $this->create(
            [
                'UserPrenom' => $data['prenom'],
                'UserNom' => $data['nom'],
                'UserEmail' => $data['email'],
                'UserMdp' => password_hash($data['mdp'], PASSWORD_DEFAULT)
            ]
        );
        

        if($User) {
            try {
                $statement = $this->connection->prepare("INSERT INTO {$this->table} (UserPrenom, UserNom, UserEmail, UserMdp) VALUES (?, ?, ?, ?)");
                $statement->execute([
                    htmlspecialchars($User->prenom),
                    htmlspecialchars($User->nom),
                    htmlspecialchars($User->email),
                    htmlspecialchars($User->mdp)
                ]);
                return true;
            } catch (PDOException $e) {
                print $e->getMessage();
                return false;
            }
        }
    }


    public function setToken($User) {
        //générer un token
        $token = bin2hex(random_bytes(8)) . "." . time();

        $User->sessionToken = $token;
        date_default_timezone_set('Europe/Brussels');
        echo time();
        //créer un cookie avec le token
        setcookie('sessionToken', $token, time()+60*60*24, "/");
        
        //update l'utilisateur en DB avec son nouveau token
        var_dump("in set token");

        $this->updateToken($User);
    
        return $User;
    }


    public function updateToken ($User) {
        try {
        
            $statement = $this->connection->prepare("UPDATE {$this->table} SET sessionToken = ? WHERE UserID = ?");
            $statement->execute([
                $User->sessionToken,
                $User->UserID
            ]);
            return true;
        } catch (PDOException $e) {
            print $e->getMessage();
            return false;
        }
    }

    public function deleteToken ($donnee, $token) {
        if(empty($token)) {
            return false;
        }
        
        try {
            $statement = $this->connection->prepare("UPDATE {$this->table} SET {$donnee} = NULL WHERE sessionToken = ?");
            $statement->execute([
                $token
            ]);
        } catch(PDOException $e) {
            print $e->getMessage();
        }
    }

}