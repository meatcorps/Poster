<?php
/**
 * This file is part of the Poster Project.
 *
 * (c) Dennis Steffen <dennis@steffen.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 */

/**
 * Debug config
 * 
 * @package DSteffen
 * @return array config
 */

$config = array();

$config["db"] = array(
        'dbname'    => 'silextest',
        'user'      => 'developer',
        'password'  => '',
        'host'      => '',
        'driver'    => 'pdo_mysql',
        'charset'   => 'utf8'
    );

$config["setup"] = true;

return $config;