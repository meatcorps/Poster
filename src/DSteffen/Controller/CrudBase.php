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
use Symfony\Component\HttpFoundation\Request;

/**
 * BaseController for editing and overview for entity's
 *
 * @author Dennis
 */
abstract class CrudBase {
    /**
     * The target entity controller
     * @var \DSteffen\Model\Manager\IBaseManager; 
     */
    protected $baseManager;
    /**
     * The target entity 
     * @var \DSteffen\Model\Entity\IBaseEntity; 
     */
    protected $baseEntity;
    /**
     * Fields for the overview table
     * @var string; 
     */
    protected $tableFields;
    /**
     * Twig template for inserting and updating 
     * @var string; 
     */
    protected $editorTemplate;
    /**
     * Twig template for the overview
     * @var string; 
     */
    protected $overviewTemplate;
    
    /**
     * Set variable for the CrudBase Controller
     * 
     * @param \DSteffen\Model\Manager\IBaseManager $baseManager
     * @param \DSteffen\Model\Entity\IBaseEntity $baseEntity
     * @param array $tableFields
     * @param string $editorTemplate
     * @param string $overviewTemplate
     */
    public function __construct(\DSteffen\Model\Manager\IBaseManager $baseManager, \DSteffen\Model\Entity\IBaseEntity $baseEntity, array $tableFields, $editorTemplate, $overviewTemplate) {
        $this->baseManager          = $baseManager;
        $this->baseEntity           = $baseEntity;
        $this->tableFields          = $tableFields;
        $this->editorTemplate       = $editorTemplate;
        $this->overviewTemplate     = $overviewTemplate;
    }

    /**
     * Setup routing. Default is /overview /create /update/{id} /delete/{id} and post. It also binds for receiving the url in twig.
     * 
     * @param \Silex\ControllerCollection $factory
     * @param string $name
     * @return \Silex\ControllerCollection
     */
    public function setupFactory(\Silex\ControllerCollection $factory, $name) {
        
        $factory->get("/overview", function(Application $app) { 
            return $this->overview($app); 
        })->bind("admin.{$name}.overview");
        
        $factory->get("/create", function(Application $app) { 
            return $this->insert($app); 
        })->bind("admin.{$name}.create");   
        
        $factory->get("/update/{id}", function(Application $app, $id) { 
            return $this->update($app, $id); 
        })->bind("admin.{$name}.update");       
        
        $factory->get("/delete/{id}", function(Application $app, $id) { 
            return $this->delete($app, $id); 
        })->bind("admin.{$name}.delete");     
        
        $factory->post("/post", function(Request $request, Application $app) { 
            return $this->post($request, $app); 
        })->bind("admin.{$name}.post");
        
        return $factory;
    }

    /**
     * Overridable function for receiving the model form.
     * 
     * @param array $data form fill data
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    protected function getForm($data = null) {
        return $data;
    }
    
    /**
     * Overview route. Bind: admin.<i>name</i>.overview 
     * 
     * @param Application $app
     * @return string HTML
     */
    protected function overview(Application $app) {
        $tableData = $this->baseManager->select(null, 'id,'. implode(',', $this->tableFields));
        return $app['twig']->render($this->overviewTemplate, array(
            'fields' => $this->tableFields,
            'data'   => $tableData
        ));
    }
    
    /**
     * New entity route. Bind: admin.<i>name</i>.create 
     * 
     * @param Application $app
     * @return string HTML
     */
    protected function insert(Application $app) {
        $form = $this->getForm(array("id"=>0));
        
        return $app['twig']->render($this->editorTemplate, array(
            'form'   => $form->createView(),
            'update' => false
        ));
    }
    
    /**
     * Edit entity route. Bind: admin.<i>name</i>.update
     * 
     * @param Application $app
     * @param int $id
     * @return string HTML
     */
    protected function update(Application $app, $id) {
        $data = $this->baseManager->byId($id);
        $form = $this->getForm($data);
        
        return $app['twig']->render($this->editorTemplate, array(
            'form'   => $form->createView(),
            'update' => true
        ));
    }
    
    /**
     * Handles post insert / update data. Bind: admin.<i>name</i>.post
     * 
     * @param Request $request
     * @param Application $app
     * @return string JSON with response if the request is valid.
     */
    protected function post(Request $request, Application $app) {
        $form = $this->getForm(null);
        $form->handleRequest($request);
        $success = $form->isValid();
        $errors = array();
        
        if ($success) {
            $entity = clone $this->baseEntity;
            $entity->import($form->getData());
            $entity = $this->handlePostData($entity);
            
            if ($entity == null) {
                $success = false;
            } else {
                if (intval($entity->getId()) > 0) {
                    $this->baseManager->update($entity);
                } else {
                    $this->baseManager->insert($entity);
                }
            }
        } else {
            $errors = (string)$form->getErrors(true, false);
        }
        return $app->json(["valid"=>$success, "errors"=>$errors]);
    }
    
    /**
     * Overridable function for custom data handling by receiving post (insert/update) data.
     * 
     * @param \DSteffen\Model\Entity\IBaseEntity $entity
     * @return \DSteffen\Model\Entity\IBaseEntity
     */
    protected function handlePostData(\DSteffen\Model\Entity\IBaseEntity $entity) {
        return $entity;
    }
    
    /**
     * Handles removing an entity. Bind: admin.<i>name</i>.delete
     * 
     * @param Application $app
     * @param type $id
     * @return string JSON with response if the request is valid.
     */
    protected function delete(Application $app, $id) {
        $success = $this->baseManager->removeById($id);
        return $app->json(["valid"=>$success]);
    }
}
