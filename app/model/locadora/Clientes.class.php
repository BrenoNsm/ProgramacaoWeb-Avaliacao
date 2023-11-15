<?php

class Clientes extends TRecord
{
    const TABLENAME = 'clientes';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('nome');
        parent::addAttribute('cpf');
        parent::addAttribute('endereco');
        parent::addAttribute('telefone');
    }
}