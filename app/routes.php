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
 * Setup route controllers
 * 
 * @package DSteffen
 */

$app->mount("/", new \DSteffen\Controller\IndexController());
$app->mount("/", new \DSteffen\Controller\SecureController());
$app->mount("/admin/post/", new \DSteffen\Controller\PostController($app));
$app->mount("/admin/admins/", new \DSteffen\Controller\UserController($app));