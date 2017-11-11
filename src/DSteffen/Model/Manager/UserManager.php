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
use DSteffen\Model\Entity\User;

/**
 * UserManager for the User Entity class
 *
 * @author Dennis Steffen
 */
class UserManager extends BaseManager {
    /**
     * Create instance for crud user manager
     * 
     * @param \Doctrine\DBAL\Connection $conn
     */
    public function __construct(\Doctrine\DBAL\Connection $conn) {
        parent::__construct($conn, "user", new User());
    }
    
    /**
     * Wrapper for finding by username
     * 
     * @param string $name
     * @return array list of entity's
     */
    public function getUser($name) {
        return $this->select(array("user"=>$name));
    }
}
