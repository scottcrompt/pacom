<?php
class Cours
{
    private $id;
    private $CoursDateTime;
    private $CoursPlace;
    private $CoursPrix;
    private $ecurie = false;

    public function __construct($id, $CoursDateTime, $CoursPlace, $CoursPrix,$ecurie =false)
    {
        $this->id = $id;
        $this->CoursDateTime = $CoursDateTime;
        $this->CoursPlace = $CoursPlace;
        $this->CoursPrix = $CoursPrix;
        $this->ecurie = $ecurie;
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
