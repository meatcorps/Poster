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

/**
 * UserController set the parameters for the CrudBase. It's controls the crud routing for users (admins). 
 *
 * @author Dennis
 */
class UserController extends CrudBase implements ControllerProviderInterface {
    /**
     * Main Silex app so we can access it from other functions
     * @var \Silex\Application 
     */
    private $app;
    
    /**
     * Setup the CrudBase class
     * 
     * @param Application $app
     */
    public function __construct(Application $app) {
        $this->app = $app;
        parent::__construct(
                $app['db.user'], 
                new \DSteffen\Model\Entity\User(), 
                ["name", "user", "created_at", "updated_at"], 
                "/admin/usereditor.twig", 
                "/admin/useroverview.twig"
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

        return $this->setupFactory($factory, 'user');
    } 
    
    /**
     * Receiving the model form for the CrudBase class.
     * 
     * @param array $data form fill data
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    protected function getForm($data = null) {
        if (isset($data["password"])) {
            $data["password"] = "";
        }
        $form = $this->app['form.factory']->createBuilder('DSteffen\\Form\\UserForm', $data)->getForm();
        return $form;
    }
    
    /**
     * Override for custom handling post data. It's just a wrapper for handlePostData()
     * 
     * @param \DSteffen\Model\Entity\IBaseEntity $entity
     * @return \DSteffen\Model\Entity\IBaseEntity
     */
    protected function handlePostData(\DSteffen\Model\Entity\IBaseEntity $entity) {
        return $this->handleUser($entity);
    }
    
    /**
     * Set's the role always to ROLE_ADMIN 
     * Check if the password is set by new entity and hash the password. 
     * By editing if password blanc it sets it old value.
     * 
     * @param \DSteffen\Model\Entity\User $entity
     * @return \DSteffen\Model\Entity\User
     */
    private function handleUser(\DSteffen\Model\Entity\User $entity) {
        if (intval($entity->getId()) == 0 && strlen($entity->getPassword()) < 6) {
            return null;
        }
        
        $entity->setRoles("ROLE_ADMIN");
        
        if (strlen($entity->getPassword()) == 0) {
            $original = $this->app['db.user']->byId($entity->getId());
            $entity->setPassword($original->getPassword());
        } else {
            $entity->setPassword($this->app['security.default_encoder']->encodePassword($entity->getPassword(), ''));
        }
        
        return $entity;
    }
}