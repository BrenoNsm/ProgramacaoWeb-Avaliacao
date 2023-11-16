<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Wrapper\BootstrapFormBuilder;

/**
 * FormProfissionalCinema
 */
class FormSocio extends TPage
{
    protected $form;      // form
    protected $datagrid;  // datagrid
    protected $loaded;
    protected $pageNavigation;  // pagination component
    
    // trait with onSave, onEdit, onDelete, onReload, onSearch...
    use Adianti\Base\AdiantiStandardFormListTrait;
    
    /**
     * Class constructor
     * Creates the page, the form, and the listing
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->setDatabase('locadora'); // Substitua 'seu_banco_de_dados' pelo nome do seu banco de dados
        $this->setActiveRecord('Socio'); // Substitua 'Socio' pelo nome da sua classe Active Record para Socio
        $this->setDefaultOrder('id_socio', 'asc'); // Defina a ordem padrão
        $this->setLimit(-1); // Desative o limite para a datagrid
        
        // create the form
        $this->form = new BootstrapFormBuilder('FormSocio');
        $this->form->setFormTitle(('Socio'));
        
        // create the form fields
        $id_socio   = new TEntry('id_socio');
        $nome_socio = new TEntry('nome_socio');
        $end_rua    = new TEntry('end_rua');
        $end_numero = new TEntry('end_numero');
        $end_bairro = new TEntry('end_bairro');
        
        // add the form fields
        $this->form->addFields([new TLabel('ID Sócio')], [$id_socio]);
        $this->form->addFields([new TLabel('Nome Sócio')], [$nome_socio]);
        $this->form->addFields([new TLabel('Endereço Rua')], [$end_rua]);
        $this->form->addFields([new TLabel('Endereço Número')], [$end_numero]);
        $this->form->addFields([new TLabel('Endereço Bairro')], [$end_bairro]);
        
        // define the form actions
        $this->form->addAction('Save', new TAction([$this, 'onSave']), 'fa:save green');
        $this->form->addActionLink('Clear', new TAction([$this, 'onClear']), 'fa:eraser red');
        
        // make id not editable
        $id_socio->setEditable(FALSE);
        
        // create the datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
        
        // add the columns
        $col_id_socio   = new TDataGridColumn('id_socio', 'ID Sócio', 'right', '10%');
        $col_nome_socio = new TDataGridColumn('nome_socio', 'Nome Sócio', 'left', '20%');
        $col_end_rua    = new TDataGridColumn('end_rua', 'Endereço Rua', 'left', '20%');
        $col_end_numero = new TDataGridColumn('end_numero', 'Endereço Número', 'right', '10%');
        $col_end_bairro = new TDataGridColumn('end_bairro', 'Endereço Bairro', 'left', '20%');
        
        $this->datagrid->addColumn($col_id_socio);
        $this->datagrid->addColumn($col_nome_socio);
        $this->datagrid->addColumn($col_end_rua);
        $this->datagrid->addColumn($col_end_numero);
        $this->datagrid->addColumn($col_end_bairro);
        
        $col_id_socio->setAction(new TDataGridAction([$this, 'onReload']), ['order' => 'id_socio']);
        
        // define row actions
        $action1 = new TDataGridAction([$this, 'onEdit'], ['key' => '{id_socio}']);
        $action2 = new TDataGridAction([$this, 'onDelete'], ['key' => '{id_socio}']);
        
        $this->datagrid->addAction($action1, 'Edit', 'far:edit blue');
        $this->datagrid->addAction($action2, 'Delete', 'far:trash-alt red');
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // wrap objects inside a table
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        //$vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);
        $vbox->add(TPanelGroup::pack('', $this->datagrid));
        
        // pack the table inside the page
        parent::add($vbox);
    }
}

?>