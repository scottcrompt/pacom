<?php
class ChevalDAO extends AbstractDAO
{
    public function __construct()
    {
        parent::__construct('cheval');
    }

    public function user($userID)
    {
        return $this->belongsTo(new UserDAO, "UserID", $userID);
    }

    public function cours($ChevalID)
    {
        return $this->belongsToMany(new CoursDAO, "usercours", $ChevalID, "UserCoursChevalXID", "UserCoursCoursXID", "CoursID");
    }


    public function create($result)
    {
        return new Cheval(
            !empty($result['ChevalID']) ? $result['ChevalID'] : 0,
            $result['ChevalNom']
        );
    }


    public function deepcreate($result)
    {
        return new Cheval(
            !empty($result['ChevalID']) ? $result['ChevalID'] : 0,
            $result['ChevalNom'],
            $this->user($result['ChevalUserXID'])
        );
    }


    public function store($data)
    {
        if (empty($data['nom']) || empty($data['user'])) {
            throw new Exception();
            return false;
        }
        $cheval = $this->deepcreate(
            [
                'ChevalID' => 0,
                'ChevalNom' => $data['nom'],
                'ChevalUserXID' => $data['user']
            ]
        );
        if ($cheval) {
            try {
                $statement = $this->connection->prepare("INSERT INTO {$this->table} (ChevalNom, ChevalUserXID) VALUES (?, ?)");
                $statement->execute([
                    htmlspecialchars($cheval->nom),
                    htmlspecialchars($cheval->user->id)
                ]);
                return true;
            } catch (PDOException $e) {
                throw new Exception();
                print $e->getMessage();
                return false;
            }
        }
        return false;
    }



    public function delete($data)
    {
        if (empty($data['id'])) {
            throw new Exception();
            return false;
        }
        // cherche s'il y a des matchs associés à l'équipe pour les supprimer également
        /*
        $associatedMatchs = $this->fetchIntermediateDAO('equipe_matchs', $data['id'], 'xidEquipe', 'xidMatchs', new MatchsDAO);
        if (!empty($associatedMatchs)) {
            foreach ($associatedMatchs as $associatedMatch) {
                try {
                    $statement = $this->connection->prepare("DELETE FROM matchs WHERE id = ?");
                    $statement->execute([
                        $associatedMatch->id
                    ]);
                } catch (PDOException $e) {
                    print $e->getMessage();
                }
            }
        }
        */
        try {
            $statement = $this->connection->prepare("DELETE FROM {$this->table} WHERE ChevalID = ?");
            $statement->execute([
                $data['id']
            ]);
        } catch (PDOException $e) {
            throw new Exception();
            print $e->getMessage();
            return false;
        }
    }



    public function update($id, $data)
    {
        if (empty($data['nom']) || empty($data['user']) || empty($id)) {
            throw new Exception("Veuillez remplir tous les champs");
            return false;
        }
        try {
            var_dump($data);
            $statement = $this->connection->prepare("UPDATE {$this->table} SET ChevalNom = ?, ChevalUserXID = ? WHERE ChevalID = ?");
            $statement->execute([
                htmlspecialchars($data['nom']),
                htmlspecialchars($data['user']),
                htmlspecialchars($id)
            ]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Problème de BD - Appelez le support");
            print $e->getMessage();
            return false;
        }
    }
}
