<?php

use Adianti\Database\TRecord;

class Dvd extends TRecord{
    const TABLENAME = 'Dvd';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('titulo');
        parent::addAttribute('estado');
        
    }
}

?>