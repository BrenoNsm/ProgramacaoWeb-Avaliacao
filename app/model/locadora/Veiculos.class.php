<?php

class Veiculos extends TRecord
{
    const TABLENAME = 'veiculos';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('marca');
        parent::addAttribute('modelo');
        parent::addAttribute('ano');
        parent::addAttribute('placa');
        parent::addAttribute('disponivel');
    }
}