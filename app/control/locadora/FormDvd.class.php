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
class FormDvd extends TPage
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
        
        $this->setDatabase('locadora'); // Substitua 'seu_banco_de_dados' pelo nome do seu banco de dados
        $this->setActiveRecord('Dvd'); // Substitua 'Dvd' pelo nome da sua classe Active Record para DVDs
        $this->setDefaultOrder('id_dvd', 'asc'); // Defina a ordem padrão
        $this->setLimit(-1); // Desative o limite para a datagrid
        
        // create the form
        $this->form = new BootstrapFormBuilder('FormDvd');
        $this->form->setFormTitle(('Dvd'));
        
        // create the form fields
        $id_dvd  = new TEntry('id_dvd');
        $titulo  = new TEntry('titulo');
        $estado  = new TEntry('estado');
        
        // add the form fields
        $this->form->addFields([new TLabel('ID DVD')], [$id_dvd]);
        $this->form->addFields([new TLabel('Título')], [$titulo]);
        $this->form->addFields([new TLabel('Estado')], [$estado]);
        
        // define the form actions
        $this->form->addAction('Save', new TAction([$this, 'onSave']), 'fa:save green');
        $this->form->addActionLink('Clear', new TAction([$this, 'onClear']), 'fa:eraser red');
        
        // make id not editable
        $id_dvd->setEditable(FALSE);
        
        // create the datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
        
        // add the columns
        $col_id_dvd = new TDataGridColumn('id_dvd', 'ID DVD', 'right', '10%');
        $col_titulo = new TDataGridColumn('titulo', 'Título', 'left', '20%');
        $col_estado = new TDataGridColumn('estado', 'Estado', 'left', '20%');
        
        $this->datagrid->addColumn($col_id_dvd);
        $this->datagrid->addColumn($col_titulo);
        $this->datagrid->addColumn($col_estado);
        
        $col_id_dvd->setAction(new TDataGridAction([$this, 'onReload']), ['order' => 'id_dvd']);
        
        // define row actions
        $action1 = new TDataGridAction([$this, 'onEdit'], ['key' => '{id_dvd}']);
        $action2 = new TDataGridAction([$this, 'onDelete'], ['key' => '{id_dvd}']);
        
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