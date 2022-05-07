<?php class Role
{
    private $id;
    private $prix;
    private $frequence;
    private $cheval = false;
    private $paiement = false;


    public function __construct($id, $prix,$frequence,$cheval = false,$paiement = false)
    {
        $this->id = $id;
        $this->prix = $prix;
        $this->frequence = $frequence;
        $this->cheval = $cheval;
        $this->pripaiementx = $paiement;
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