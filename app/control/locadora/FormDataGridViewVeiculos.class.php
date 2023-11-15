<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Validator\TRequiredValidator;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Form\TCombo;
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
class FormDataGridViewVeiculos extends TPage
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
        $this->setActiveRecord('Veiculos'); // define the Active Record
        $this->setDefaultOrder('id', 'asc'); // define the default order
        $this->setLimit(-1); // turn off limit for datagrid
        
        // create the form
        $this->form = new BootstrapFormBuilder('form_veiculos');
        $this->form->setFormTitle(('Cadastro de Veículos'));
        
        // create the form fields
        $id     = new TEntry('id');
        $marca   = new TEntry('marca');
        $modelo   = new TEntry('modelo');
        $ano   = new TEntry('ano');
        $placa   = new TEntry('placa');
        $disponivel   = new TCombo('disponivel');
        $disponivel->addItems( [ '1' => 'Sim', '0' => 'Não' ] );
        
        // add the form fields
        $this->form->addFields( [new TLabel('ID')],    [$id] );
        $this->form->addFields( [new TLabel('Marca', 'red')],  [$marca] );
        $this->form->addFields( [new TLabel('Modelo', 'red')],  [$modelo] );
        $this->form->addFields( [new TLabel('Ano', 'red')],  [$ano] );
        $this->form->addFields( [new TLabel('Placa', 'red')],  [$placa] );
        $this->form->addFields( [new TLabel('Disponível', 'red')],  [$disponivel] );
        
        $placa->addValidation('Placa', new TRequiredValidator);
        
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
        $col_placa  = new TDataGridColumn('placa', 'Placa', 'left', '10%');
        $col_marca  = new TDataGridColumn('marca', 'Marca', 'left', '30%');
        $col_modelo  = new TDataGridColumn('modelo', 'Modelo', 'left', '30%');
        $col_ano  = new TDataGridColumn('ano', 'Ano', 'left', '10%');
        $col_disponivel  = new TDataGridColumn('disponivel', 'Disponível', 'left', '10%');
        
        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_placa);
        $this->datagrid->addColumn($col_marca);
        $this->datagrid->addColumn($col_modelo);
        $this->datagrid->addColumn($col_ano);
        $this->datagrid->addColumn($col_disponivel);

        $col_disponivel->setTransformer(function($value, $object, $row) {
            if($value==true){
                return 'Sim';
            }else{
                return 'Não';
            }
        });
        
        $col_id->setAction( new TAction([$this, 'onReload']),   ['order' => 'id']);
        $col_placa->setAction( new TAction([$this, 'onReload']), ['order' => 'placa']);
        
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