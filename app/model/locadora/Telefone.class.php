<?php

use Adianti\Database\TRecord;

class Telefone  extends TRecord{
    const TABLENAME = 'Telefone';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('id_telefone');
        parent::addAttribute('id_socio');
        parent::addAttribute('num_telefone');
    }
}

?>