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
 * Entity of User Database Table
 * 
 * @author Dennis Steffen
 */
class User extends BaseEntity {    
    /**
     * Variable for the field 'name' max 100 chars
     * @var string 
     */
    protected $name;
    /**
     * Variable for the field 'user' max 50 chars
     * @var string 
     */
    protected $user;
    /**
     * Variable for the field 'password' max 255 chars
     * @var string 
     */
    protected $password;
    /**
     * Variable for the field 'roles' max 200 chars
     * @var string 
     */
    protected $roles;
    
    /**
     * Receive name
     * 
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Receive user
     * 
     * @return string
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Receive password
     * 
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Receive roles
     * 
     * @return string
     */
    public function getRoles() {
        return $this->roles;
    }

    /**
     * Set name
     * 
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Set user
     * 
     * @param string $user
     */
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * Set password
     * 
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }
    /**
     * Set roles
     * 
     * @param string $roles
     */
    public function setRoles($roles) {
        $this->roles = $roles;
    }
}