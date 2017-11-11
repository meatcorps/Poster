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
 * Base abstraction class for table entity's implements from array access. This is for easy usage in combination with Doctrine DBAL DB connection
 *
 * @author Dennis Steffen
 */
abstract class BaseEntity implements \ArrayAccess, IBaseEntity {
    //Every table must have id created_at and updated_at
    
    /**
     * Auto increment value
     * @var int 
     */
    protected $id;
    /**
     * When the entity is inserted
     * @var string
     */
    protected $created_at;
    /**
     * When the entity is inserted and or updated  
     * @var string
     */
    protected $updated_at;
    
    /**
     * Create Entity and fill it data
     * 
     * @param array $data
     */
    public function __construct(array $data=array()) {
        $this->import($data);
    }
    
    /**
     * Fill it with data by array
     * 
     * @param array $data
     */
    public function import(array $data=array()) {
        foreach ($data as $key => $value) {
            $this->__set($key, $value);
        }
    }
    
    /**
     * Auto increment value
     * 
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Only accepted when incoming value is null or the value is null
     * 
     * @param int $id
     */
    public function setId($id) {
        if ($this->id == null || $id == null) {
            $this->id = $id;
        }
    }
    
    /**
     * Returns when is the row created
     * 
     * @return string
     */
    public function getCreatedAt() {
        return $this->created_at;
    }

    /**
     * Set the created date. Will automatically be set by inserting. Only possible when the protected value is null
     * 
     * @param string $created_at
     */
    public function setCreatedAt($created_at) {
        if ($this->created_at == null) {
            $this->created_at = $created_at;
        }
    }
    
    /**
     * When the row is inserted or updated 
     * 
     * @return string
     */
    public function getUpdatedAt() {
        return $this->updated_at;
    }

    /**
     * Please do not use this. Will automatically be set by inserting or updating
     * 
     * @param string $updated_at
     */
    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }
    
    /* Universal getter / setters for easy value access. */
    
    /**
     * Get value by calling the method or by property. Type of the value is unknown
     * 
     * @param type $name
     * @return type
     */
    public function __get($name) {
        $method = "get".ucwords($name);
        
        if (method_exists($this, $method)) {
            return $this->$method();
        } elseif (property_exists($this, $name)) {
            return $this->$name;
        }
    }
    
    /**
     * Set value by calling the method or by property. Type of the value is unknown
     * 
     * @param type $name
     * @param type $value
     * @return type
     */
    public function __set($name, $value) {
        $method = "set".ucwords($name);
        
        if (method_exists($this, $method)) {
            return $this->$method($value);
        } elseif (property_exists($this, $name)) {
            return $this->$name = $value;
        }
    }
    
    /* ArrayAccess methods */
    
    /**
     * Whether an offset exists
     * 
     * @param type $offset
     * @return type
     */
    public function offsetExists($offset) {
        return property_exists($this, $offset);
    }
    
    /**
     * Offset to retrieve
     * 
     * @param type $offset
     * @return type
     */
    public function offsetGet($offset) {
        return $this->__get($offset);
    }
    
    /**
     * Assign a value to the specified offset
     * 
     * @param type $offset
     * @param type $value
     * @return type
     */
    public function offsetSet($offset, $value) {
        return $this->__set($offset, $value);
    }
    
    /**
     * Unset an offset
     * 
     * @param type $offset
     */
    public function offsetUnset($offset) {
        if (property_exists($this, $offset)) {
            unset($this->$offset);
        }
    }
    
    /* Generic methods */
    
    /**
     * Convert object to string
     * 
     * @return string
     */
    public function __toString() {
        $string = "";
        $data = $this->toArray();
        foreach ($data as $key => $value) {
            $string .= "$key => \"$value\"\n";
        }
        return $string;
    }
    
    /**
     * Convert object to array
     * 
     * @return array
     */
    public function toArray(){
        //remove null  
        $array = array_filter(get_object_vars($this), function($value){
            return $value!=null;
        });
      
        return $array;
    }
    
    /**
     * Convert object to JSON
     * 
     * @return string
     */
    public function serialize() {
        return json_encode($this->toArray());
    }
    
    /**
     * Convert JSON string to data and fill the data
     * 
     * @param string $json
     */
    public function deserialize($json) {
        $data = json_decode($json, true);
        $this->__construct($data);
    }
}
