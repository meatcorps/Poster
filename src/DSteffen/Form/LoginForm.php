<?php
/**
 * This file is part of the Poster Project.
 *
 * (c) Dennis Steffen <dennis@steffen.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DSteffen\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use \Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Form Template for the login form. 
 *
 * @author Dennis Steffen
 */
class LoginForm extends AbstractType implements FormTypeInterface {
    /**
     * Form template css class
     * @var string 
     */
    protected $fieldClass = "";
    
    /**
     * Create form
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add("_username", TextType::class, array("label"=>"Username", "required"=> true, "attr"=>array("class"=>$this->fieldClass, "placeholder"=>"Username")));
        $builder->add("_password", PasswordType::class, array("label"=>"Password", "required"=> true, "attr"=>array("class"=>$this->fieldClass, "placeholder"=>"Password")));
        $builder->add("submit", SubmitType::class, array("label"=>"Login", "attr"=>array("class"=>"btn btn-primary")));
    }
    
    /**
     * Override function so there will no blockfix. The security.firewall need clean names _username and _password. 
     * 
     * @return null
     */
    public function getBlockPrefix() {
        return null;
    }
}