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
            $this->ecurie($result['CoursEcurieXID']),
            $this->cheval($result['CoursID']),
            $this->user($result['CoursID']),
            $this->paiement($result['CoursID'])
        );
    }
} // SELECT * FROM usercours where UserCoursCoursXID = IDCours