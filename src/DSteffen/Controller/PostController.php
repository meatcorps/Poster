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
use DSteffen\Controller\CrudBase;
use DSteffen\Model\Entity\Post;

/**
 * PostController set the parameters for the CrudBase. It's controls the crud routing for posts. 
 *
 * @author Dennis Steffen
 */
class PostController extends CrudBase implements ControllerProviderInterface {
    /**
     * Main Silex app so we can access it from other functions
     * @var \Silex\Application 
     */
    private $app;
    
    /**
     * Initialization of the PostController. It set the parameters for CrudBase
     * 
     * @param \Silex\Application $app
     */
    public function __construct(Application $app) {
        $this->app = $app;
        parent::__construct(
                $app['db.post'], 
                new Post(), 
                ["title", "created_at", "updated_at", "author"], 
                "/admin/posteditor.twig", 
                "/admin/postoverview.twig"
        );
    }
    
    /**
     * Set routes
     * 
     * @param Application $app
     * @return \Silex\ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app) {
        $factory = $app["controllers_factory"];
        
        return $this->setupFactory($factory, 'post');
    }
    
    /**
     * Receive form model for the admin posteditor.twig
     * 
     * @param array $data
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    protected function getForm($data = null) {
        $form = $this->app['form.factory']->createBuilder('DSteffen\\Form\\PostForm', $data)->getForm();
        return $form;
    }
}
