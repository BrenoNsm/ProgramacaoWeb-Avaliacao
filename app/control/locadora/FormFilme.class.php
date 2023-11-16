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
class FormFilme extends TPage
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
        $this->setActiveRecord('Filme'); // Substitua 'Filme' pelo nome da sua classe Active Record para filmes
        $this->setDefaultOrder('id', 'asc'); // Defina a ordem padrão
        $this->setLimit(-1); // Desative o limite para a datagrid
        
        // create the form
        $this->form = new BootstrapFormBuilder('FormFilme');
        $this->form->setFormTitle(('Filme'));
        
        // create the form fields
        $id            = new TEntry('id');
        $titulo        = new TEntry('titulo');
        $cod_gen       = new TEntry('cod_gen');
        $nome_prof     = new TEntry('nome_prof');
        $sobrenome_prof = new TEntry('sobrenome_prof');
        
        // add the form fields
        $this->form->addFields([new TLabel('ID')], [$id]);
        $this->form->addFields([new TLabel('Título')], [$titulo]);
        $this->form->addFields([new TLabel('Código Gênero')], [$cod_gen]);
        $this->form->addFields([new TLabel('Nome prof')], [$nome_prof]);
        $this->form->addFields([new TLabel('Sobrenome prof', 'red')], [$sobrenome_prof]);
        
        // define the form actions
        $this->form->addAction('Save', new TAction([$this, 'onSave']), 'fa:save green');
        $this->form->addActionLink('Clear', new TAction([$this, 'onClear']), 'fa:eraser red');
        
        // make id not editable
        $id->setEditable(FALSE);
        
        // create the datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
        
        // add the columns
        $col_id            = new TDataGridColumn('id', 'ID', 'right', '10%');
        $col_titulo        = new TDataGridColumn('titulo', 'Título', 'left', '20%');
        $col_cod_gen       = new TDataGridColumn('cod_gen', 'Código Gênero', 'right', '10%');
        $col_nome_prof     = new TDataGridColumn('nome_prof', 'Nome prof', 'right', '10%');
        $col_sobrenome_prof = new TDataGridColumn('sobrenome_prof', 'Sobrenome prof', 'left', '10%');
        
        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_titulo);
        $this->datagrid->addColumn($col_cod_gen);
        $this->datagrid->addColumn($col_nome_prof);
        $this->datagrid->addColumn($col_sobrenome_prof);
        
        $col_id->setAction(new TDataGridAction([$this, 'onReload']), ['order' => 'id']);
        
        // define row actions
        $action1 = new TDataGridAction([$this, 'onEdit'], ['key' => '{id}']);
        $action2 = new TDataGridAction([$this, 'onDelete'], ['key' => '{id}']);
        
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