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
    
    public function newAction()
    {
        $formParceiro = new Admin_Form_Parceiro('new');
        
        $titulo = urldecode( $this->_getParam('nome') );
        $titulo = str_replace(' ', '_',$titulo);
        
        if( $this->getRequest()->isPost() ) {
            $data = $this->getRequest()->getPost();
            if ( $formParceiro->isValid($data) ){                
                /*Faz upload do arquivo*/
                $upload = new Zend_File_Transfer_Adapter_Http();
                foreach ($upload->getFileInfo() as $file => $info) {                                     
                    $extension = pathinfo($info['name'], PATHINFO_EXTENSION); 
                    $upload->addFilter('Rename', array( 'target' => APPLICATION_PATH.'/../public/images/parceiros/parceiro-'.$titulo.'.'.$extension,'overwrite' => true,));
                }
                try {
                    $upload->receive();
                } catch (Zend_File_Transfer_Exception $e) {
                    die($e->getMessage());
                }
                /*Adicionar dados no banco de dados*/
                $dadosImagem =array(
                    'descricao'  =>   'Logotipo'.$this->_getParam('nome'),
                    'nome'      =>  'parceiro-'.$titulo.'.'.$extension,
                    'local'     =>  '/images/parceiros/',
                    'categoria' => '1'
                );
                $modeloImagem = new Admin_Model_Imagem();
                $idImagem = $modeloImagem->insert($dadosImagem);
                $dados['nome'] = $data['titulo'];
                $dados['descricao'] = $data['descricao'];
                $dados['texto'] = $data['texto'];
                $dados['autor'] = $this->_usuario->idUsuario;
                $dados['dtInclusao'] = date('Y-m-d');
                $dados['patrocinador'] = $data['sponsor'];
                $dados['thumb'] = $idImagem;
                $this->_modelo->insert($dados);
                return $this->_helper->redirector->goToRoute( array('module'=>'admin','controller' => 'blog'), null, true);
            }else{
                $this->view->erro='Dados Invalidos';
                $this->view->formMateria = $formParceiro->populate($data);
            }
        }
        $this->view->formMateria = $formParceiro;
    }

}