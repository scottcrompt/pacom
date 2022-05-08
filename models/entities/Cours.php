<?php
class Cours
{
    private $id;
    private $CoursDateTime;
    private $CoursPlace;
    private $CoursPrix;
    private $ecurie;
    private $user;
    private $cheval;
    private $paiement;

    public function __construct($id, $CoursDateTime, $CoursPlace, $CoursPrix,$ecurie =false,$user = false,$cheval = false,$paiement = false)
    {
        $this->id = $id;
        $this->CoursDateTime = $CoursDateTime;
        $this->CoursPlace = $CoursPlace;
        $this->CoursPrix = $CoursPrix;
        $this->ecurie = $ecurie;
        $this->user = $user;
        $this->cheval = $cheval;
        $this->paiement = $paiement;
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
