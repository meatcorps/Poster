<?php
/**
 * This file is part of the Poster Project.
 *
 * (c) Dennis Steffen <dennis@steffen.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DSteffen\Model\Entity;

/**
 * Interface for Entity's 
 * 
 * @author Dennis
 */
interface IBaseEntity {
    
    /**
     * Convert object to array
     * 
     * @return array
     */
    public function toArray();
    
    /**
     * Fill it with data by array
     * 
     * @param array $data
     */
    public function import(array $data=array());
    
    /**
     * Auto increment value
     * 
     * @return int
     */
    public function getId();
    
    /**
     * Only accepted when incoming value is null or the value is null
     * 
     * @param int $id
     */
    public function setId($id);
    
    /**
     * Set the created date. Will automatically be set by inserting. Only possible when the protected value is null
     * 
     * @param string $created_at
     */
    public function setCreatedAt($created_at);
    
    /**
     * Please do not use this. Will automatically be set by inserting or updating
     * 
     * @param string $updated_at
     */
    public function setUpdatedAt($updated_at);
}
