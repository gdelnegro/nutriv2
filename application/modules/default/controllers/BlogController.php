<?php

class Default_BlogController extends Zend_Controller_Action
{

    public function init()
    {
        
    }

    public function indexAction()
    {
        $blog = new Admin_Model_Blog();        
        $noticias = $blog->pesquisaPost(null, null);
        $noticiasRecentes = $blog->pesquisaPost(null, null, 2);
        $this->view->materias = $noticias;
        $this->view->materiasRecentes = $noticiasRecentes;
    }
    
    public function showAction(){
        $id = $this->_getParam('id');
        $blog = new Admin_Model_Blog();        
        $noticias = $blog->pesquisaPost($id, null);   
        $imagem = new Admin_Model_Imagem();
        $dadosImagem = $imagem->pesquisaImagem($noticias['thumb']);
        $noticiasRecentes = $blog->pesquisaPost(null, null, 3);
        $this->view->imagem = $dadosImagem;
        $this->view->materias = $noticias;
        $this->view->materiasRecentes = $noticiasRecentes;
    }

}
