<?php class Cheval
{
    private $id;
    private $nom;
    private $user = false;

    public function __construct($id, $nom, $user = false)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->user = $user;
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
