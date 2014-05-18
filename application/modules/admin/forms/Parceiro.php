<?php

class Admin_Form_Parceiro extends Zend_Form
{

    protected $exibir;
    protected $tipo;
    protected $usr;

    public function __construct($tipo = null, $usr = null, $options = null) {
        $this->tipo = strtoupper($tipo);
        $this->usr = $usr;
        
        if ( strtoupper($tipo)=='EDIT' OR strtoupper($tipo)=='NEW'){
            $this->exibir = null;
        }else if ( strtoupper($tipo) == 'SHOW' ){
            $this->exibir = true;
        }
        parent::__construct($options);
    }

    public function init()
    {
        
        $this->setMethod('post');
        $this->setAttrib('horizontal', true);
        $idPatrocinador = new Zend_Form_Element_Hidden('idPatrocinador');
        
        $nome = new Zend_Form_Element_Text('nome');
        $nome->setLabel('Nome do parceiro');
        $nome->setRequired(true)
                ->setFilters(array('StringTrim'))
                ->setValidators( array(
                     array('notEmpty', true, array(
                         'messages' => array(
                             'isEmpty' => 'O nome não pode ser nulo'
                         )
                     ))
               ))
                ->setAttrib('disabled', $this->exibir);
        
        $arquivo = new Zend_Form_Element_File('logo');
        $arquivo->setLabel('Logotipo')
                ->setRequired('true')
                ->addValidator('Count', false, 1)
                ->addValidator('Size',false,5502400)
                ->addValidator('Extension',false,'jpg,png,gif');
        
        $categoria = new Zend_Form_Element_Select('categoria');
        $categoria->setLabel('Categoria')
                ->setRequired('true')
                ->addMultiOptions($listaCategorias);
        
        $this->addElements( array(
            $idPatrocinador,
            $nome,
            $arquivo,
        ));
        
        $submit = new Zend_Form_Element_Submit('Enviar');
        
        $this->addElement($submit);
    }


}

