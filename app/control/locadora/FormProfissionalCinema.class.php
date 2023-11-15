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
        $this->setActiveRecord('Profissional_Cinema '); // define the Active Record
        $this->setDefaultOrder('nome_prof', 'asc'); // define the default order
        $this->setLimit(-1); // turn off limit for datagrid
        
        // create the form
        $this->form = new BootstrapFormBuilder('FormProfissionalCinema');
        $this->form->setFormTitle(('Profissional Cinema'));
        
        // create the form fields
        $nome_prof    = new TEntry('nome_prof');
        $sobrenome_prof   = new TEntry('sobrenome_prof');
        $pais_origem   = new TEntry('pais_origem');
        $tipo   = new TEntry('tipo');
        
        // add the form fields
        $this->form->addFields( [new TLabel('nome prof')],    [$nome_prof] );
        $this->form->addFields( [new TLabel('sobrenome prof', 'red')],  [$sobrenome_prof] );
        $this->form->addFields( [new TLabel('pais origem', 'red')],  [$pais_origem] );
        $this->form->addFields( [new TLabel('tipo', 'red')],  [$tipo] );
        
        
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
        $col_nome_prof    = new TDataGridColumn('nome_prof', 'nome prof', 'right', '10%');
        $col_sobrenome_prof = new TDataGridColumn('sobrenome_prof', 'sobrenome prof', 'left', '10%');
        $col_pais_origem  = new TDataGridColumn('pais_origem', 'pais origem', 'left', '10%');
        $col_tipo  = new TDataGridColumn('tipo', 'tipo', 'left', '30%');
        //$col_veiculo  = new TDataGridColumn('veiculos', 'veiculos', 'left', '30%');
        
        
        $this->datagrid->addColumn($col_nome_prof);
        $this->datagrid->addColumn($col_sobrenome_prof);
        $this->datagrid->addColumn($col_pais_origem);
        $this->datagrid->addColumn($col_tipo);
        
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