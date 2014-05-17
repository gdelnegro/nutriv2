<?php

class Admin_BlogController extends Zend_Controller_Action
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
        $this->_modelo = new Admin_Model_Blog();
    }

    public function indexAction()
    {
        $dados = $this->_modelo->pesquisaPost();
        $paginator = Zend_Paginator::factory($dados);
        $paginator->setItemCountPerPage(50);
        $paginator->setPageRange(10);
        $paginator->setCurrentPageNumber($this->_request->getParam('pagina'));
        $this->view->paginator = $paginator;
    }
    
    public function newAction()
    {
        $formMateria = new Admin_Form_Post();
        
        $titulo = urldecode( $this->_getParam('titulo') );
        $titulo = str_replace(' ', '_',$titulo);
        
        if( $this->getRequest()->isPost() ) {
            $data = $this->getRequest()->getPost();
            if ( $formMateria->isValid($data) ){                
                /*Faz upload do arquivo*/
                $upload = new Zend_File_Transfer_Adapter_Http();
                foreach ($upload->getFileInfo() as $file => $info) {                                     
                    $extension = pathinfo($info['name'], PATHINFO_EXTENSION); 
                    $upload->addFilter('Rename', array( 'target' => APPLICATION_PATH.'/../public/images/materias/materia-'.$titulo.'.'.$extension,'overwrite' => true,));
                }
                try {
                    $upload->receive();
                } catch (Zend_File_Transfer_Exception $e) {
                    die($e->getMessage());
                }
                /*Adicionar dados no banco de dados*/
                $dadosImagem =array(
                    'descricao'  =>   'Logotipo'.$this->_getParam('sponsor'),
                    'nome'      =>  'materia-'.$titulo.'.'.$extension,
                    'local'     =>  '../public/images/materias/',
                    'categoria' => '2'
                );
                $modeloImagem = new Admin_Model_Imagem();
                die(var_dump($idImagem = $modeloImagem->insert($dadosImagem)));
                $dados['titulo'] = $data['titulo'];
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
                $this->view->formMateria = $formMateria->populate($data);
            }
        }
        $this->view->formMateria = $formMateria;
    }
}