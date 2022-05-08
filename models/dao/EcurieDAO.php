<?php

class EcurieDAO extends AbstractDAO
{
    public function __construct(){
        parent::__construct('ecurie');
    }

    public function user($ecurieID){
        return $this->hasMany(new UserDAO(),'UserEcurieXID',$ecurieID);
    }
    public function cours($ecurieID){
        return $this->hasMany(new CoursDAO(),'CoursEcurieXID',$ecurieID);
    }

    public function deepcreate ($result) {
        return new Ecurie(
            $result['EcurieID'],
            $result['EcurieNom'],
            $result['EcurieAdresse'],
            $result['EcurieVille'],
            $result['EcuriePlace']
        );
        
    }
    public function create ($result) {
        return new Ecurie(
            $result['EcurieID'],
            $result['EcurieNom'],
            $result['EcurieAdresse'],
            $result['EcurieVille'],
            $result['EcuriePlace']
        );
    }

    
}?>