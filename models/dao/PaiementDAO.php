<?php

class PaiementDAO extends AbstractDAO
{
    public function __construct(){
        parent::__construct('paiement');
    }

    public function cours($PaiementID){
        return $this->belongsToMany(new CoursDAO, "usercours", $PaiementID, "UserCoursPaiementXID","UserCoursCoursXID","CoursID");
    }

    //belongstoMany pension 

    public function deepcreate ($result) {
        return new Role(
            $result['PaiementID'],
            $result['PaiementStatut']
        );
        
    }
    public function create ($result) {
        return new Role(
            $result['PaiementID'],
            $result['PaiementStatut']
        );
    }

    
}?>