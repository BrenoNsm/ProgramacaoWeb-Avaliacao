<?php 
use Adianti\Database\TRecord;

class Genero extends TRecord{

    const TABLENAME = "Genero";

    const PRIMARYKEY = "cod_gen";

    const IDPOLICY = "max";

    public function __construct($cod_gen = NULL){
        parent::__construct($cod_gen);
        parent::addAttribute('denominacao');
    }
}

?>