<?php
class UserDAO extends AbstractDAO
{
    public function __construct(){
        parent::__construct('user');
    }


    public function role($roleID){
        return $this->belongsTo(new RoleDAO,"RoleID", $roleID);
    }
    public function ecurie($ecurieID){
        return $this->belongsTo(new EcurieDAO,"EcurieID", $ecurieID);
    }

    public function cheval($userID){
        return $this->hasMany(new ChevalDAO(),'ChevalUserXID',$userID);
    }

    public function cours($UserID){
        return $this->belongsToMany(new CoursDAO, "usercours", $UserID, "UserCoursUserXID","UserCoursCoursXID","CoursID");
    }


    public function create ($result) {
        return new User(
            !empty($result['UserID']) ? $result['UserID'] : 0,
            $result['UserPrenom'],
            $result['UserNom'],
            $result['UserEmail'],
            $result['UserTelephone'],
            $result['UserMdp'],
            !empty($result['sessionToken'])? $result['sessionToken'] : null,
            !empty($result['UserRoleXID'])? $result['UserRoleXID'] : 1
        );
    }   
    public function deepcreate ($result) {
        return new User(
            !empty($result['UserID']) ? $result['UserID'] : 0,
            $result['UserPrenom'],
            $result['UserNom'],
            $result['UserEmail'],
            $result['UserTelephone'],
            $result['UserMdp'],
            !empty($result['sessionToken'])? $result['sessionToken'] : null,
            $this->role($result['UserRoleXID']),
            $this->ecurie($result['UserEcurieXID']),
            $this->cours($result['UserID']),
            $this->cheval($result['UserID'])
        );
    }


    public function store ($data) {

        // Si l'utilisateur s'inscrit, role "user" par défaut :

        if (!isset($data['role'])){
        if (empty($data['prenom']) | empty($data['nom']) | empty($data['email']) | empty($data['mdp']) | empty($data['mdp2']) | empty($data['email2']) |
        ($data['mdp']) != ($data['mdp2']) | ($data['email']) != ($data['email2'])) {
            throw new Exception("");
            return false;
        }
        
        $User = $this->create(
            [
                'UserPrenom' => $data['prenom'],
                'UserNom' => $data['nom'],
                'UserEmail' => $data['email'],
                'UserTelephone' => $data['telephone'],
                'UserMdp' => password_hash($data['mdp'], PASSWORD_DEFAULT)
            ]
        );
        

        if($User) {
            try {
                $statement = $this->connection->prepare("INSERT INTO {$this->table} (UserPrenom, UserNom, UserEmail, UserTelephone, UserMdp) VALUES (?, ?, ?, ?, ?)");
                $statement->execute([
                    htmlspecialchars($User->prenom),
                    htmlspecialchars($User->nom),
                    htmlspecialchars($User->email),
                    htmlspecialchars($User->telephone),
                    htmlspecialchars($User->mdp)
                ]);
                return true;
            } catch (PDOException $e) {
                print $e->getMessage();
                return false;
            }
        }
    }


    // Si l'admin ajoute un utilisateur et choisi son rôle :


    elseif(isset($data['role'])){
        if (empty($data['prenom']) | empty($data['nom']) | empty($data['email']) | empty($data['mdp']) | empty($data['mdp2']) | empty($data['email2']) | empty($data['role']) |
        ($data['mdp']) != ($data['mdp2']) | ($data['email']) != ($data['email2'])) {
            throw new Exception("");
            return false;
        }
        $User = $this->create(
            [
                'UserPrenom' => $data['prenom'],
                'UserNom' => $data['nom'],
                'UserEmail' => $data['email'],
                'UserTelephone' => $data['telephone'],
                'UserRoleXID' => $data['role'],
                'UserMdp' => password_hash($data['mdp'], PASSWORD_DEFAULT)
            ]
        );
        if($User) {
            try {
                $statement = $this->connection->prepare("INSERT INTO {$this->table} (UserPrenom, UserNom, UserEmail, UserTelephone,UserRoleXID, UserMdp) VALUES (?, ?, ?, ?, ?, ?)");
                $statement->execute([
                    htmlspecialchars($User->prenom),
                    htmlspecialchars($User->nom),
                    htmlspecialchars($User->email),
                    htmlspecialchars($User->telephone),
                    htmlspecialchars($User->role),
                    htmlspecialchars($User->mdp)
                ]);
                return true;
            } catch (PDOException $e) {
                throw new Exception("");
                print $e->getMessage();
                return false;
            }
        }
    }
    }


    public function verify ($data) {
        if (empty($data['email']) || empty($data['mdp'])) {
            throw new Exception();
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
          
        } catch (PDOException $e) {
            print $e->getMessage();
            throw new Exception();
            return false;
        }
    }

    public function update($id, $data)
    {
        if (empty($data['prenom']) || empty($data['nom']) || empty($id) || empty($data['telephone']) || empty($data['role'])) {
            throw new Exception("Veuillez remplir tous les champs");
            return false;
        }
        try {
            var_dump($data);
            $statement = $this->connection->prepare("UPDATE {$this->table} SET UserPrenom = ?, UserNom = ?, UserTelephone = ?, UserRoleXID = ? WHERE UserID = ?");
            $statement->execute([
                htmlspecialchars($data['prenom']),
                htmlspecialchars($data['nom']),
                htmlspecialchars($data['telephone']),
                htmlspecialchars($data['role']),
                htmlspecialchars($id)
            ]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Problème de BD - Appelez le support");
            print $e->getMessage();
            return false;
        }
    }

    public function delete($data)
    {
        if (empty($data['id'])) {
            throw new Exception();
            return false;
        }
        try {
            $statement = $this->connection->prepare("DELETE FROM {$this->table} WHERE UserID = ?");
            $statement->execute([
                $data['id']
            ]);
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
            throw new Exception();
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