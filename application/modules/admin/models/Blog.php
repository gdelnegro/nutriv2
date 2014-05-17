<?php
/**
 * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
 */
class Admin_Model_Blog
{
    protected $dbMaterias;
    
    /**
     * Método construtor
     */
    public function __construct() {
        $this->dbMaterias = new Admin_Model_DbTable_Materias();
    }
    
    /**
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @param array $dados dados que serão inseridos
     */
    public function insert(array $dados){
        try{
            $this->dbMaterias->insert($dados);
        } catch (Exception $ex) {
            die(var_dump($ex->getMessage()));
        }
    }
    
    /**
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @param int $idPost id do registro que será deletado
     */
    public function delete($idPost){
        try{
            $where = $this->dbMaterias->getAdapter()->quoteInto("idMateria = ?", $idPost);
            $this->dbMaterias->delete($where);
        } catch (Exception $ex) {
            die(var_dump($ex->getMessage()));
        }
    }
    
    /**
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @param int $idPost
     * @param array $dados
     */
    public function update($idPost, array $dados){
        try{
            $where = $this->dbMaterias->getAdapter()->quoteInto("idMateria = ?", $idPost);
            $this->dbMaterias->update($dados, $where);
        } catch (Exception $ex) {
            die(var_dump($ex->getMessage()));
        }
    }
    
    /**
     * @author Gustavo Del Negro <gustavodelnegro@gmail.com>
     * @param int $idPost
     * @param int $autor
     * @return array
     */
    public function pesquisaPost($idPost = null, $autor = null, $limit = null){
        try{
            $select = $this->dbMaterias->select();
            $select->from('materias');
            if(!is_null($idPost)){
                $select->where('idMateria = ?',$idPost);
            }if(!is_null($autor)){
                $select->where('autor = ?', $autor);
            }
            $select->order('dtInclusao');
            if(!is_null($limit) && $limit>1){
                $select->limit($limit);
            }
            $stmt = $select->query();
            $dados = $stmt->fetchAll();
            if($idPost != null){
                return $dados[0];
            }else{
                return $dados;
            }
        } catch (Exception $ex) {
            die(var_dump($ex->getMessage()));
        }  
    }
}

