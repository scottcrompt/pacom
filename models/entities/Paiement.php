<?php class Role
{
    private $id;
    private $statut;
    private $cours = false;

    public function __construct($id, $statut,$cours = false)
    {
        $this->id = $id;
        $this->statut = $statut;
        $this->cours = $cours;
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