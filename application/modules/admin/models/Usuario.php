<?php

class Admin_Model_Usuario
{
    protected $dbUsuario;
    
    /**
     * Método construtor
     */
    public function __construct() {
        $this->dbUsuario = new Admin_Model_DbTable_Usuarios();
    }
    
    /**
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @param array $dados dados que serão inseridos
     */
    public function insert(array $dados){
        try{
            $this->dbUsuario->insert($dados);
        } catch (Exception $ex) {
            die(var_dump($ex->getMessage()));
        }
    }
    
    /**
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @param int $idUsuario id do registro que será deletado
     */
    public function delete($idUsuario){
        try{
            $where = $this->dbUsuario->getAdapter()->quoteInto("idUsuarios = ?", $idUsuario);
            $this->dbUsuario->delete($where);
        } catch (Exception $ex) {
            die(var_dump($ex->getMessage()));
        }
    }
    
    /**
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @param int $idUsuario
     * @param array $dados
     */
    public function update($idUsuario, array $dados){
        try{
            $where = $this->dbUsuario->getAdapter()->quoteInto("idUsuarios = ?", $idUsuario);
            $this->dbUsuario->update($dados, $where);
        } catch (Exception $ex) {
            die(var_dump($ex->getMessage()));
        }
    }

}

