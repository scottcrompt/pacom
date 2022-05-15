<?php
class User
{
    private $id;
    private $prenom;
    private $nom;
    private $email;
    private $telephone;
    private $mdp;
    private $sessionToken = false;
    private $role = false;
    private $ecurie = false;
    private $cours = false;
    private $cheval = false;

    public function __construct($id, $prenom, $nom, $email, $telephone, $mdp,$sessionToken = false, $role = false,$ecurie =false, $cours = false, $cheval = false)
    {
        $this->id = $id;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->mdp = $mdp;
        $this->sessionToken = $sessionToken;
        $this->role = $role;
        $this->ecurie = $ecurie;
        $this->cours = $cours;
        $this->cheval = $cheval;
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