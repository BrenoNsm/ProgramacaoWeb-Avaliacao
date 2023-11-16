<?php
use Adianti\Database\TRecord;

class Locacoes extends TRecord
{
    const TABLENAME = 'locacoes';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    public function __construct($id = NULL)
    {
        parent::__construct($id);
        parent::addAttribute('data_inicio');
        parent::addAttribute('data_fim');
        parent::addAttribute('veiculo_id');
        parent::addAttribute('cliente_id');
        parent::addAttribute('valor_total');
    }

    public function set_clientes(Clientes $object){
        $this->clientes = $object;
        $this->clientes_id=$object->id;
    }

    public function get_clinetes(){
        if(empty($this->clientes)){
            $this->clientes = new Clientes($this->clientes->id);
        }
        return $this->clientes;
    }

    public function set_veiculos(Veiculos $object){
        $this->veiculos = $object;
        $this->veiculos_id=$object->id;
    }

    public function get_veiculos(){
        if(empty($this->veiculos)){
            $this->veiculos = new Veiculos($this->veiculos->id);
        }
        return $this->veiculos;
    }

}