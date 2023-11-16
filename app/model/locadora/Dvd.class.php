<?php

use Adianti\Database\TRecord;

class Dvd extends TRecord{
    const TABLENAME = 'Dvd';
    const PRIMARYKEY= 'id_dvd';
    const IDPOLICY =  'max'; // {max, serial}
    
    public function __construct($id_dvd = NULL)
    {
        parent::__construct($id_dvd);
        parent::addAttribute('titulo');
        parent::addAttribute('estado');
        
    }
}

?>