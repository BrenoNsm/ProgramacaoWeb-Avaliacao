<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Form\TDate;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Wrapper\TDBUniqueSearch;
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Wrapper\BootstrapFormBuilder;

/**
 * StandardFormDataGridView
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class FormLocacao extends TPage
{
    protected $form;      // form
    protected $datagrid;  // datagrid
    protected $loaded;
    protected $pageNavigation;  // pagination component
    
    // trait with onSave, onEdit, onDelete, onReload, onSearch...
    use Adianti\Base\AdiantiStandardFormListTrait;
    
    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->setDatabase('locadora'); // define the database
        $this->setActiveRecord('locacoes'); // define the Active Record
        $this->setDefaultOrder('id', 'asc'); // define the default order
        $this->setLimit(-1); // turn off limit for datagrid
        
        // create the form
        $this->form = new BootstrapFormBuilder('form_locacao');
        $this->form->setFormTitle(('Locação de Veículos'));
        
        // create the form fields
        $id     = new TEntry('id');
        $dataInicio   = new TDate('data_inicio');
        $dataFim   = new TDate('data_fim');
        $veiculo_id = new TDBUniqueSearch('veiculo_id', 'dblocadora', 'Veiculos', 'id', 'placa','disponivel=true');
        $cliente_id = new TDBUniqueSearch('cliente_id', 'dblocadora', 'Clientes', 'id', 'nome');
        
        // add the form fields
        $this->form->addFields( [new TLabel('ID')],    [$id] );
        $this->form->addFields( [new TLabel('Dt Inicio Locação', 'red')],  [$dataInicio] );
        $this->form->addFields( [new TLabel('Dt Fim Locação', 'red')],  [$dataFim] );
        $this->form->addFields( [new TLabel('Veículo', 'red')],  [$veiculo_id] );
        $this->form->addFields( [new TLabel('Cliente', 'red')],  [$cliente_id] );
        
        //$placa->addValidation('Placa', new TRequiredValidator);
        
        // define the form actions
        $this->form->addAction( 'Save', new TAction([$this, 'onSave']), 'fa:save green');
        $this->form->addActionLink( 'Clear',new TAction([$this, 'onClear']), 'fa:eraser red');
        
        // make id not editable
        $id->setEditable(FALSE);
        
        // create the datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
        
        // add the columns
        $col_id    = new TDataGridColumn('id', 'Id', 'right', '10%');
        $col_dtinicio  = new TDataGridColumn('data_inicio', 'Data de Inicio', 'left', '10%');
        $col_dtfim  = new TDataGridColumn('data_fim', 'Data de Fim', 'left', '10%');
        $col_veiculo  = new TDataGridColumn('veiculo', 'Veiculo', 'left', '30%');
        //$col_veiculo  = new TDataGridColumn('veiculos', 'veiculos', 'left', '30%');
        
        
        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_dtinicio);
        $this->datagrid->addColumn($col_dtfim);
        $this->datagrid->addColumn($col_veiculo);
        
        $col_id->setAction( new TAction([$this, 'onReload']),   ['order' => 'id']);
        //$col_placa->setAction( new TAction([$this, 'onReload']), ['order' => 'placa']);
        
        // define row actions
        $action1 = new TDataGridAction([$this, 'onEdit'],   ['key' => '{id}'] );
        $action2 = new TDataGridAction([$this, 'onDelete'], ['key' => '{id}'] );
        
        $this->datagrid->addAction($action1, 'Edit',   'far:edit blue');
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