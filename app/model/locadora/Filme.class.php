<?php

use Adianti\Database\TRecord;

class Filme extends TRecord{
    const TABLENAME = 'Filme';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('titulo');
        parent::addAttribute('cod_gen');
        parent::addAttribute('nome_prof');
        parent::addAttribute('sobrenome_prof');
    }
}

?>