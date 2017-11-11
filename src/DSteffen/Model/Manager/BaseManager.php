<?php
/**
 * This file is part of the Poster Project.
 *
 * (c) Dennis Steffen <dennis@steffen.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DSteffen\Model\Manager;
use DSteffen\Model\Entity\IBaseEntity;

/**
 * Base manager for Doctrine DBAL DB Crud
 *
 * @author Dennis
 */
abstract class BaseManager implements IBaseManager {
    /**
     * Database connection
     * @var \Doctrine\DBAL\Connection
     */
    protected $conn;
    /**
     * Target entity
     * @var IBaseEntity
     */
    private $baseEntity;
    /**
     * Name of the table
     * @var string
     */
    protected $tableName;
    
    /**
     * Set base variables for the CrudManager
     * 
     * @param \Doctrine\DBAL\Connection $conn
     * @param string $tableName
     * @param IBaseEntity $baseEntity
     */
    public function __construct(\Doctrine\DBAL\Connection $conn, $tableName, IBaseEntity $baseEntity) {
        $this->conn = $conn;
        $this->tableName = $tableName;
        $this->baseEntity = $baseEntity;
    }
    
    /**
     * Convert array result to list of Entity's
     * 
     * @param array $list
     * @return array
     */
    protected function arrayResultToEntity(array $list) {
        $objects = array();
        foreach ($list as $item) {
            $object = clone $this->baseEntity;
            $object->import($item);
            $objects[]  = $object;
        } 
        return $objects;
    }
    
    /**
     * General basic select function receiving all entity's inside the table
     * 
     * @param array $where
     * @param string $fields
     * @param string $orderBy
     * @param bool $asc
     * @param int $start
     * @param int $max
     * @return array list of entity's
     */
    public function select(array $where = null, $fields = "*", $orderBy = "", $asc = false, $start = null, $max = null) {
        $queryBuilder = $this->conn->createQueryBuilder();
        $queryBuilder->select($fields)
                     ->from($this->tableName, $this->tableName);
        
        if ($orderBy != "") {
            $queryBuilder->orderBy($orderBy, $asc ? "ASC":"DESC");
        }
        
        if ($where != null) {
            $queryBuilder->where(key($where) . " = ?")
                         ->setParameter(0, $where[key($where)]);
        }
        
        if ($start != null) {
            $queryBuilder->setFirstResult($start);
        }
        
        if ($max != null) {
            $queryBuilder->setMaxResults($max);
        }
        
        return $this->queryBuilderToEntity($queryBuilder);
    }
    
    /**
     * Insert by Entity. Returning back the entity with auto increment value;
     * 
     * @param IBaseEntity $entity
     * @return IBaseEntity
     */
    public function insert(IBaseEntity $entity) {
        $entity->setCreatedAt(date("Y-m-d H:i:s"));
        $entity->setUpdatedAt(date("Y-m-d H:i:s"));
        $array = $entity->toArray();
        $array["id"] = null;
        $this->conn->insert($this->tableName, $array);
        $entity->setId($this->conn->lastInsertId());
        return $entity;
    }
    
    /**
     * Get entity by id
     * 
     * @param int $id
     * @return DSteffen\Model\Entity\IBaseEntity
     */
    public function byId($id) {
        $data = $this->select(["id"=>$id]);
        if (count($data) > 0) {
            return $data[0];
        } 
        return null;
    }
    
    /**
     * Get list of resulting entity's from Doctrine's DBAL QueryBuilder
     * 
     * @param \Doctrine\DBAL\Query\QueryBuilder $queryBuilder
     * @return array list of entity's
     */
    protected function queryBuilderToEntity(\Doctrine\DBAL\Query\QueryBuilder $queryBuilder) {
        return $this->arrayResultToEntity($queryBuilder->execute()
                                                       ->fetchAll());
    }
    
    /**
     * Update row by entity. 
     * 
     * @param IBaseEntity $entity
     * @return int number of effected rows
     */
    public function update(IBaseEntity $entity) {
        $entity->setUpdatedAt(date("Y-m-d H:i:s"));
        return $this->conn->update($this->tableName, $entity->toArray(), array("id"=>$entity->getId()));
    }
    
    /**
     * Remove by entity
     * 
     * @param IBaseEntity $entity
     * @return int number of effected rows
     */
    public function remove(IBaseEntity $entity) {
        return $this->removeById($entity->getId());
    }
    
    /**
     * Remove by Id
     * 
     * @param type $id
     * @return int number of effected rows
     */
    public function removeById($id) {
        return $this->conn->delete($this->tableName, array("id"=>$id));
    }
}
