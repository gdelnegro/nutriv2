<?php

class Admin_Model_Parceiro
{
    protected $dbParceiro;
    
    /**
     * Método construtor
     */
    public function __construct() {
        $this->dbParceiro = new Admin_Model_DbTable_Patrocinador();
    }
    
    /**
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @param array $dados dados que serão inseridos
     */
    public function insert(array $dados){
        try{
            $this->dbParceiro->insert($dados);
        } catch (Exception $ex) {
            die(var_dump($ex->getMessage()));
        }
    }
    
    /**
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @param int $idPatrocinador id do registro que será deletado
     */
    public function delete($idPatrocinador){
        try{
            $where = $this->dbParceiro->getAdapter()->quoteInto("idPatrocinador = ?", $idPatrocinador);
            $this->dbParceiro->delete($where);
        } catch (Exception $ex) {
            die(var_dump($ex->getMessage()));
        }
    }
    
    /**
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @param int $idPatrocinador
     * @param array $dados
     */
    public function update($idPatrocinador, array $dados){
        try{
            $where = $this->dbParceiro->getAdapter()->quoteInto("idPatrocinador = ?", $idPatrocinador);
            $this->dbParceiro->update($dados, $where);
        } catch (Exception $ex) {
            die(var_dump($ex->getMessage()));
        }
    }
    
    public function pesquisaParceiro($idParceiro = null){
        try{
            $select = $this->dbParceiro->select();
            $select->from('patrocinador');
            if(!is_null($idParceiro)){
                $select->where('idPatrocinador = ?',$idParceiro);
            }
            $stmt = $select->query();
            $dados = $stmt->fetchAll();
            if($idParceiro != null){
                return $dados[0];
            }else{
                return $dados;
            }
        } catch (Exception $ex) {
            die(var_dump($ex->getMessage()));
        }
    }
    
    public function listaParceiros(){
        try{
            $select = $this->dbParceiro->select()
                ->from('patrocinador', array('key'=>'idPatrocinador','value'=>'nome'));
            $stmt = $select->query();
            $result = $stmt->fetchAll();
            return $result;
        } catch (Exception $ex) {
            die(var_dump($ex->getMessage()));
        }
    }

}

