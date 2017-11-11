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
 * Interface for the crud manager that handles entity's
 * 
 * @category DatabaseControllers
 * @author Dennis
 */
interface IBaseManager {
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
    public function select(array $where = null, $fields = "*", $orderBy = "", $asc = false, $start = null, $max = null);
    
    /**
     * Insert by Entity. Returning back the entity with auto increment value;
     * 
     * @param IBaseEntity $entity
     * @return IBaseEntity
     */
    public function insert(IBaseEntity $entity);
    
    /**
     * Get entity by id
     * 
     * @param int $id
     * @return DSteffen\Model\Entity\IBaseEntity
     */
    public function byId($id);
    
    /**
     * Update row by entity. 
     * 
     * @param IBaseEntity $entity
     * @return int number of effected rows
     */
    public function update(IBaseEntity $entity);
    
    /**
     * Remove by entity
     * 
     * @param IBaseEntity $entity
     * @return int number of effected rows
     */
    public function remove(IBaseEntity $entity);
    
    /**
     * Remove by Id
     * 
     * @param type $id
     * @return int number of effected rows
     */
    public function removeById($id);
    
}
