<?php

use Adianti\Database\TRecord;

class profissional_cinema extends TRecord{
    const TABLENAME = 'profissional_cinema';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('nome_prof');
        parent::addAttribute('sobrenome_prof');
        parent::addAttribute('pais_origem');
        parent::addAttribute('tipo');
    }
}

?>