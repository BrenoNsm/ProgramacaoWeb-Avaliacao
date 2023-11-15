<?php 
use Adianti\Database\TRecord;

class Genero extends TRecord{

    const TABLENAME = "Genero";

    const PRIMARYKEY = "id";

    const IDPOLICY = "max";

    public function __construct($id = NULL){
        parent::__construct(self::TABLENAME, $id);
        parent::addAttribute('cod_gen');
        parent::addAttribute('denominacao');
    }
}

?>