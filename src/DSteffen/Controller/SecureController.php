<?php
/**
 * This file is part of the Poster Project.
 *
 * (c) Dennis Steffen <dennis@steffen.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DSteffen\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * SecureController sets routes for the security.firewall. So we have routing for login/logout and home after login.
 *
 * @author Dennis Steffen
 */
class SecureController implements ControllerProviderInterface {
    
    /**
     * Set routes
     * 
     * @param Application $app
     * @return \Silex\ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app) {
        $factory = $app["controllers_factory"];

        $factory->get("/login", array($this, "login"))->bind('admin.login');
          
        $factory->get("/admin/logout", array($this, "void"))->bind('admin.logout');

        $factory->get("/admin/", array($this, "admin"))->bind('admin.home');

        return $factory;
    }

    /**
     * Receive login form Bind: admin.login
     * 
     * @param Request $request
     * @param Application $app
     * @return string HTML
     */
    public function login(Request $request, Application $app){
        $form = $app['form.factory']->createBuilder('DSteffen\\Form\\LoginForm', array(
            "_username" => $app['session']->get('_security.last_username')
        ))->getForm();
        return $app['twig']->render('login.twig', array(
            'error'         => $app['security.last_error']($request),
            'form'          => $form->createView()
        ));
    }
    
    /**
     * Receive home for admin. Bind: admin.home
     * 
     * @param Application $app
     * @return string HTML
     */
    public function admin(Application $app){
        return $app['twig']->render('admin/home.twig');
    }
    
    /**
     * Used for log out. It redirect so no real response is needed. It's prevent the no routing found error
     * 
     * @param Application $app
     * @return string empty
     */
    public function void(Application $app){
        return "";
    }
}