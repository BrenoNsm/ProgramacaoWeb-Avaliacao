<?php

use Adianti\Database\TRecord;

class Telefone  extends TRecord{
    const TABLENAME = 'Telefone';
    const PRIMARYKEY= 'id_telefone';
    const IDPOLICY =  'max'; // {max, serial}
    
    public function __construct($id_telefone = NULL)
    {
        parent::__construct($id_telefone);
        parent::addAttribute('id_socio');
        parent::addAttribute('num_telefone');
    }
}

?>