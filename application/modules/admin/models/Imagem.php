<?php

class Admin_Model_Imagem
{
    protected $dbImagem;
    
    /**
     * Método construtor
     */
    public function __construct() {
        $this->dbImagem = new Admin_Model_DbTable_Imagens();
    }
    
    /**
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @param array $dados dados que serão inseridos
     */
    public function insert(array $dados){
        try{
            return $this->dbImagem->insert($dados);
        } catch (Exception $ex) {
            die(var_dump($ex->getMessage()));
        }
    }
    
    /**
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @param int $idImagens id do registro que será deletado
     */
    public function delete($idImagens){
        try{
            $where = $this->dbImagem->getAdapter()->quoteInto("idImagens = ?", $idImagens);
            $this->dbImagem->delete($where);
        } catch (Exception $ex) {
            die(var_dump($ex->getMessage()));
        }
    }
    
    /**
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @param int $idImagens
     * @param array $dados
     */
    public function update($idImagens, array $dados){
        try{
            $where = $this->dbImagem->getAdapter()->quoteInto("idImagens = ?", $idImagens);
            $this->dbImagem->update($dados, $where);
        } catch (Exception $ex) {
            die(var_dump($ex->getMessage()));
        }
    }
    
    /**
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @param int $idImagem
     * @return array
     */
    public function pesquisaImagem($idImagem = null){
        try{
            $select = $this->dbImagem->select();
            $select->from('imagens');
            if(!is_null($idImagem)){
                $select->where('idImagens = ?',$idImagem);
            }
            $stmt = $select->query();
            $dados = $stmt->fetchAll();
            if($idImagem != null){
                return $dados[0];
            }else{
                return $dados;
            }
        } catch (Exception $ex) {
            die(var_dump($ex->getMessage()));
        }
        
    }

}

