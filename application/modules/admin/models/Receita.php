<?php

class Admin_Model_Receita
{
    protected $dbReceitas;
    
    /**
     * Método construtor
     */
    public function __construct() {
        $this->dbReceitas = new Admin_Model_DbTable_Receitas();
    }
    
    /**
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @param array $dados dados que serão inseridos
     */
    public function insert(array $dados){
        try{
            $this->dbReceitas->insert($dados);
        } catch (Exception $ex) {
            die(var_dump($ex->getMessage()));
        }
    }
    
    /**
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @param int $id id do registro que será deletado
     */
    public function delete($id){
        try{
            $where = $this->dbReceitas->getAdapter()->quoteInto("id = ?", $id);
            $this->dbReceitas->delete($where);
        } catch (Exception $ex) {
            die(var_dump($ex->getMessage()));
        }
    }
    
    /**
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @param int $id
     * @param array $dados
     */
    public function update($id, array $dados){
        try{
            $where = $this->dbReceitas->getAdapter()->quoteInto("id = ?", $id);
            $this->dbReceitas->update($dados, $where);
        } catch (Exception $ex) {
            die(var_dump($ex->getMessage()));
        }
    }

}

