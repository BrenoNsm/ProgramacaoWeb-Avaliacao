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
class FormTelefone extends TPage
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
        
        $this->setDatabase('locadora'); 
        $this->setActiveRecord('Telefone'); 
        $this->setDefaultOrder('id_telefone', 'asc'); 
        $this->setLimit(-1); 
        
        // create the form
        $this->form = new BootstrapFormBuilder('FormTelefone');
        $this->form->setFormTitle(('Telefone'));
        
        // create the form fields
        $id_telefone = new TEntry('id_telefone');
        $id_socio    = new TEntry('id_socio');
        $num_telefone = new TEntry('num_telefone');
        
        // add the form fields
        $this->form->addFields([new TLabel('ID Telefone')], [$id_telefone]);
        $this->form->addFields([new TLabel('ID Sócio')], [$id_socio]);
        $this->form->addFields([new TLabel('Número Telefone')], [$num_telefone]);
        
        // define the form actions
        $this->form->addAction('Save', new TAction([$this, 'onSave']), 'fa:save green');
        $this->form->addActionLink('Clear', new TAction([$this, 'onClear']), 'fa:eraser red');
        
        // make id not editable
        $id_telefone->setEditable(FALSE);
        
        // create the datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
        
        // add the columns
        $col_id_telefone = new TDataGridColumn('id_telefone', 'ID Telefone', 'right', '10%');
        $col_id_socio    = new TDataGridColumn('id_socio', 'ID Sócio', 'right', '10%');
        $col_num_telefone = new TDataGridColumn('num_telefone', 'Número Telefone', 'left', '20%');
        
        $this->datagrid->addColumn($col_id_telefone);
        $this->datagrid->addColumn($col_id_socio);
        $this->datagrid->addColumn($col_num_telefone);
        
        $col_id_telefone->setAction(new TDataGridAction([$this, 'onReload']), ['order' => 'id_telefone']);
        
        // define row actions
        $action1 = new TDataGridAction([$this, 'onEdit'], ['key' => '{id_telefone}']);
        $action2 = new TDataGridAction([$this, 'onDelete'], ['key' => '{id_telefone}']);
        
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