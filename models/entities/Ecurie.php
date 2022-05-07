<?php
class Ecurie
{
    private $id;
    private $nom;
    private $adresse;
    private $ville;
    private $nbplace;

    public function __construct($id, $nom, $adresse,$ville, $nbplace)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->ville = $ville;
        $this->nbplace = $nbplace;

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