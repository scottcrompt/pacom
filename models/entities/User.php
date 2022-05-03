<?php
class User
{
    private $id;
    private $prenom;
    private $nom;
    private $email;
    private $mdp;
    private $role = false;
    private $ecurie = false;
    private $sessionToken = false;

    public function __construct($id, $prenom, $nom, $email,$mdp, $role = false,$ecurie =false, $sessionToken = false)
    {
        $this->id = $id;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->email = $email;
        $this->mdp = $mdp;
        $this->role = $role;
        $this->ecurie = $ecurie;
        $this->sessionToken = $sessionToken;

    }


    public function __get($prop)
    {
        if (property_exists($this, $prop)) {
            return $this->$prop;
        }
    }

    
    public function __set($prop, $value)
    {
        if (property_exists($this, $prop)) {
            $this->$prop = $value;
        }
    }
}
?>