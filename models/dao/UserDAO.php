<?php
class UserDAO extends AbstractDAO
{
    public function __construct(){
        parent::__construct('user');
    }


    public function role($roleID){
        return $this->belongsTo(new RoleDAO,"RoleID", $roleID);
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
            !empty($result['UserID']) ? $result['UserID'] : 0,
            $result['UserPrenom'],
            $result['UserNom'],
            $result['UserEmail'],
            $result['UserMdp'],
            $this->role($result['UserRoleXID']),
            //$this->matchs($result['id'])   ------------------------------
        );
    }


    public function store ($data) {
        if (empty($data['nom']) || empty($data['prenom']) || empty($data['email']) || empty($data['mdp'])) {
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


    public function verify ($data) {
        if (empty($data['email']) || empty($data['mdp'])) {
            return false;
        }
        
        try {
            $statement = $this->connection->prepare("SELECT * FROM {$this->table} WHERE UserEmail = ?");
            $statement->execute([
                $data['email']
            ]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            
            $user = $this->create($result);
            if($user) {
                if(password_verify($data['mdp'], $user->mdp)) {
                    $user = $this->setToken($user);
                    return $user;
                }
            }
          
            return false;
        } catch (PDOException $e) {
            print $e->getMessage();
            return false;
        }
    }

    public function setToken($User) {
        //générer un token
        $token = bin2hex(random_bytes(8)) . "." . time();
        $User->sessionToken = $token;
        date_default_timezone_set('Europe/Brussels');
        //créer un cookie avec le token
        setcookie('sessionToken', $token, time()+60*60*24, "/");
        
        //update l'utilisateur en DB avec son nouveau token
   
        $this->updateToken($User);
    
        return $User;
    }


    public function updateToken ($User) {
        try {
            $statement = $this->connection->prepare("UPDATE {$this->table} SET sessionToken = ? WHERE UserID = ?");
            $statement->execute([
                $User->sessionToken,
                $User->id
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