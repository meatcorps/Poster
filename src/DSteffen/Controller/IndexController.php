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

/**
 * The main index routing controller. It shows the most recent posts
 *
 * @author Dennis Steffen
 */
class IndexController implements ControllerProviderInterface {
    
    /**
     * Set routes
     * 
     * @param Application $app
     * @return \Silex\ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app) {
        $factory = $app["controllers_factory"];

        $factory->get("/", array($this, "index"))->bind('index.home');

        return $factory;
    }

    /**
     * Show latest posts. Bind: index.home
     * 
     * @param Application $app
     * @return string HTML
     */
    public function index(Application $app){
        $posts = $app["db.post"]->select(null, "*", "updated_at", false);
        
        return $app['twig']->render('home.twig', array(
            'posts'         => $posts
        ));
    }
}
