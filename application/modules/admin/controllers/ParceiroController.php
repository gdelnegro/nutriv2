<?php

class Admin_ParceiroController extends Zend_Controller_Action
{

    private $_usuario ;
    private $_modelo ;
    public function init()
    {
        $usuario = Zend_Auth::getInstance()->getIdentity();
        $this->_usuario = $usuario;
        Zend_Layout::getMvcInstance()->assign('usuario', $usuario);
        if ( !Zend_Auth::getInstance()->hasIdentity() ) {
                return $this->_helper->redirector->goToRoute( array('module'=>'admin','controller' => 'login'), null, true);
        }
        $this->_modelo = new Admin_Model_Parceiro();
    }

    public function indexAction()
    {
        // action body
    }
    
    public function listaparceiroAction(){
        $this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
        $dados = $this->_modelo->pesquisaParceiro();
        return $dados;
    }


}

