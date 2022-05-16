<?php
class CoursDAO extends AbstractDAO
{
    public function __construct(){
        parent::__construct('cours');
    }

    public function ecurie($ecurieID){
        return $this->belongsTo(new EcurieDAO,"EcurieID", $ecurieID);
    }

    public function cheval($coursID){
        return $this->belongsToMany(new ChevalDAO, "usercours", $coursID, "UserCoursCoursXID","UserCoursChevalXID","ChevalID");
    }

    public function user($coursID){
        return $this->belongsToMany(new UserDAO, "usercours", $coursID, "UserCoursCoursXID","UserCoursUserXID","UserID");
    }

    public function paiement($coursID){
        return $this->belongsToMany(new PaiementDAO, "usercours", $coursID, "UserCoursCoursXID","UserCoursPaiementXID","PaiementID");
    }

    public function create ($result) {
        return new Cours(
            !empty($result['CoursID']) ? $result['CoursID'] : 0,
            $result['CoursDateTime'],
            $result['CoursPlace'],
            $result['CoursPrix']
        );
    }   
    public function deepcreate ($result) {
      
        return new Cours(
            !empty($result['CoursID']) ? $result['CoursID'] : 0,
            $result['CoursDateTime'],
            $result['CoursPlace'],
            $result['CoursPrix'],
            $this->ecurie($result['CoursEcurieXID']) ? $result['CoursEcurieXID'] : 0,
            $this->cheval($result['CoursID']),
            $this->user($result['CoursID']),
            $this->paiement($result['CoursID'])
        );
    }

    public function store($data)
    {

        $cours = $this->deepcreate(
            [
                'CoursID' => 0,
                'CoursDateTime' => $data['date']." ".$data['time'],
                'CoursPlace' => $data['place'],
                'CoursPrix' => $data['prix'],
                'CoursEcurieXID' => $data['ecurie']
            ]
        );
        if ($cours) {
            var_dump($cours);
            try {
                $statement = $this->connection->prepare("INSERT INTO {$this->table} (CoursDateTime, CoursPlace, CoursPrix) VALUES (?, ?, ?)");
                $statement->execute([
                    htmlspecialchars($cours->CoursDateTime),
                    htmlspecialchars($cours->CoursPlace),
                    htmlspecialchars($cours->CoursPrix)
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
        try {
            $statement = $this->connection->prepare("DELETE FROM {$this->table} WHERE CoursID = ?");
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
        try {
            var_dump($data);
            $statement = $this->connection->prepare("UPDATE {$this->table} SET CoursDateTime = ?, CoursPlace = ?,CoursPrix = ? WHERE CoursID = ?");
            $statement->execute([
                htmlspecialchars($data['date']." ".$data['time']),
                htmlspecialchars($data['place']),
                htmlspecialchars($data['prix']),
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