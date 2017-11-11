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
 * Register all required components in the SilexApp.
 * 
 * @package DSteffen
 * @return Silex\Application 
 */

if (isset($phpunitbootstrap)) {
    $config = require_once __DIR__ . '/config/phpunit.php';
} elseif (isset($debugmode)) {
    $config = require_once __DIR__ . '/config/debug.php';
} else {
    $config = require_once __DIR__ . '/config/production.php';
}

$app = new Silex\Application();

$app['debug'] = $debugmode;

$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
    'twig.options'    => array(
        'cache' => __DIR__ . '/../var/cache',
    ),
));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => $config["db"],
));

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/logs/development.log',
));

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
         'default' => array(
            'pattern' => '^/admin/',
            'form' => array('login_path' => '/login', 'check_path' => '/admin/login_check', 'always_use_default_target_path'=>false, 'default_target_path'=> '/admin/'),
            'logout' => array('logout_path' => '/admin/logout'), // url to call for logging out
            'users' => function() use ($app) {
                return new DSteffen\Provider\UserLoginDataProvider($app);
            },
        ),
    ),
    'security.access_rules' => array(
        array('^/admin', 'ROLE_ADMIN'),
    )          
));
            
$app['security.default_encoder'] = function ($app) {
    return $app['security.encoder.pbkdf2'];
};
            
$app->register(new Silex\Provider\FormServiceProvider());
            
$app->register(new Silex\Provider\ValidatorServiceProvider());

$app->register(new Silex\Provider\LocaleServiceProvider());

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.domains' => array(),
));

$app['db.user'] = function($app) {
    return new \DSteffen\Model\Manager\UserManager($app['db']);
};

$app['db.post'] = function($app) {
    return new \DSteffen\Model\Manager\PostManager($app['db']);
};


if ($config["setup"]) {
    require_once __DIR__ . "/setup/dbschema.php";
}


$app->boot();

require_once __DIR__ . '/routes.php';

return $app;