<?php

class RoleDAO extends AbstractDAO
{
    public function __construct(){
        parent::__construct('role');
    }

    public function user($roleID){
        return $this->hasMany(new UserDAO(),'UserRoleXID',$roleID);
    }

    public function deepcreate ($result) {
        return new Role(
            $result['RoleID'],
            $result['RoleNom']
        );
        
    }
    public function create ($result) {
        return new Role(
            $result['RoleID'],
            $result['RoleNom']
        );
    }

    
}?>