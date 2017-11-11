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
 * Table Entity of Post
 *
 * @author Dennis Steffen
 */
class Post extends BaseEntity {
    /**
     * Title of the post
     * @var string 
     */
    protected $title;
    /**
     * Message of the post in HTML
     * @var string 
     */
    protected $message;
    /**
     * Author of the post
     * @var string 
     */
    protected $author;

    /**
     * Get Title
     * 
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Get Message
     * 
     * @return string
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * Get Author
     * 
     * @return string
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * Set Title
     * 
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Set Message
     * 
     * @param string $message
     */
    public function setMessage($message) {
        $this->message = $message;
    }

    /**
     * Set Author
     * 
     * @param string $author
     */
    public function setAuthor($author) {
        $this->author = $author;
    }
}
