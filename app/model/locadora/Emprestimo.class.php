<?php

use Adianti\Database\TRecord;

class Emprestimo  extends TRecord{
    const TABLENAME = 'Emprestimo ';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('id_dvd');
        parent::addAttribute('dataDevolucao');
        parent::addAttribute('valor_pago');
        parent::addAttribute('id_socio');
    }
}

?>