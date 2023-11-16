<?php

use Adianti\Database\TRecord;

class Socio  extends TRecord{
    const TABLENAME = 'Socio';
    const PRIMARYKEY= 'id_socio';
    const IDPOLICY =  'max'; // {max, serial}
    
    public function __construct($id_socio = NULL)
    {
        parent::__construct($id_socio);
        parent::addAttribute('end_rua');
        parent::addAttribute('end_numero');
        parent::addAttribute('end_bairro');
    }
}

?>