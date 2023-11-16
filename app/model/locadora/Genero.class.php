<?php 
use Adianti\Database\TRecord;

class Genero extends TRecord{

    const TABLENAME = "Genero";

    const PRIMARYKEY = "cod_gen";

    const IDPOLICY = "max";

<<<<<<< HEAD
    public function __construct($cod_gen = NULL){
=======
    public function __construct($cod_gen = 0){
>>>>>>> c898c367f236a1d28ce9fa4a0eb1b1a0f9ba76c3
        parent::__construct($cod_gen);
        parent::addAttribute('denominacao');
    }
}

?>