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
 * Setup table schema
 * 
 * @package DSteffen
 */

$sm = $app['db']->getSchemaManager();

$schema = $app['db']->getSchemaManager();

if (!$schema->tablesExist('post')) {
    $post = new Doctrine\DBAL\Schema\Table('post');
    $id = $post->addColumn("id",    "integer",  array("unsigned" => true));
    $id->setAutoincrement(true); 
    $post->addColumn("title",       "string",   array("length" => 200));
    $post->addColumn("message",     "text",     array("length" => 16777215));
    $post->addColumn("created_at",  "datetime", array());
    $post->addColumn("updated_at",  "datetime", array());
    $post->addColumn("author",      "string",   array("length" => 200));
    $post->setPrimaryKey(array("id"));
    $post->addIndex(array("title"));
    $schema->createTable($post);
}

if (!$schema->tablesExist('user')) {
    $user = new Doctrine\DBAL\Schema\Table('user');
    $id = $user->addColumn("id",    "integer",  array("unsigned" => true));
    $id->setAutoincrement(true); 
    $user->addColumn("name",        "string",   array("length" => 100));
    $user->addColumn("user",        "string",   array("length" => 50));
    $user->addColumn("password",    "string",   array("length" => 255));
    $user->addColumn("roles",       "string",   array("length" => 200));
    $user->addColumn("created_at",  "datetime", array());
    $user->addColumn("updated_at",  "datetime", array());
    $user->setPrimaryKey(array("id"));
    $user->addIndex(array("user", "password"));
    $schema->createTable($user);
    
    //Setup user so the admin panel is accessible
    $userManager = new \DSteffen\Model\Manager\UserManager($app['db']);
    $userEntity = new \DSteffen\Model\Entity\User();
    $userEntity->setName("Admin");
    $userEntity->setUser("admin");
    $userEntity->setRoles("ROLE_ADMIN");
    $userEntity->setPassword($app['security.default_encoder']->encodePassword('admin01', ''));
    $userManager->insert($userEntity);
}
