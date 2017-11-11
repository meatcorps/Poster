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
use DSteffen\Model\Entity\Post;

/**
 * PostManager for the Post Entity class
 *
 * @author Dennis Steffen
 */
class PostManager extends BaseManager {
    /**
     * Create instance for crud post manager
     * 
     * @param \Doctrine\DBAL\Connection $conn
     */
    public function __construct(\Doctrine\DBAL\Connection $conn) {
        parent::__construct($conn, "post", new Post());
    }
}
