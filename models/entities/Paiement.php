<?php class Role
{
    private $id;
    private $statut;

    public function __construct($id, $statut)
    {
        $this->id = $id;
        $this->statut = $statut;
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