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
class FormGenero extends TPage
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
        $this->setActiveRecord('Genero'); // define the Active Record
        $this->setDefaultOrder('cod_gen', 'asc'); // define the default order
        $this->setLimit(-1); // turn off limit for datagrid
        
        // create the form
        $this->form = new BootstrapFormBuilder('FormGenero');
        $this->form->setFormTitle(('Genero'));
        
        // create the form fields
        $cod_gen          = new TEntry('cod_gen');
        $denominacao    = new TEntry('denominacao');
        
        // add the form fields
        $this->form->addFields([new TLabel('ID')], [$cod_gen]);
        $this->form->addFields([new TLabel('denominacao')], [$denominacao]);
        
        // define the form actions
        $this->form->addAction('Save', new TAction([$this, 'onSave']), 'fa:save green');
        $this->form->addActionLink('Clear', new TAction([$this, 'onClear']), 'fa:eraser red');
        
        // make id not editable
        $cod_gen->setEditable(FALSE);
        
        // create the datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
        
        // add the columns
        $col_cod_gen           = new TDataGridColumn('cod_gen', 'ID', 'right', '10%');
        $col_denominacao    = new TDataGridColumn('denominacao', 'Denominacao', 'right', '10%');
        
        $this->datagrid->addColumn($col_cod_gen);
        $this->datagrid->addColumn($col_denominacao);
        
        $col_cod_gen->setAction(new TDataGridAction([$this, 'onReload']), ['order' => 'cod_gen']);
        
        // define row actions
        $action1 = new TDataGridAction([$this, 'onEdit'], ['key' => '{cod_gen}']);
        $action2 = new TDataGridAction([$this, 'onDelete'], ['key' => '{cod_gen}']);
        
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
