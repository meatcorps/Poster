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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Form Template for the user / admin form. 
 *
 * @author Dennis
 */
class UserForm extends AbstractType implements FormTypeInterface {
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
        $builder->add("name", TextType::class, array(
            "label" => "Full name (Minimal length is 6)", 
            "required" => true, 
            "attr"=> array(
                "class" =>$this->fieldClass,
                "placeholder"=>"Example: John Do"
            ),
            'constraints' => array(
                new Assert\NotBlank(), 
                new Assert\Length(
                    array('min' => 6)
                )
            )
        ));
        
        $builder->add("user", TextType::class, array(
            "label" => "Username (Minimal length is 6)", 
            "required" => true, 
            "attr"=> array(
                "class" =>$this->fieldClass,
                "placeholder"=>"Example: adminjohn"
            ),
            'constraints' => array(
                new Assert\NotBlank(), 
                new Assert\Length(
                    array('min' => 6)
                )
            )
        ));
        
        $builder->add("password", PasswordType::class, array(
            "label"=>"Password (Minimal length is 6)", 
            "required"=> false, 
            "attr"=> array(
                "class"=>$this->fieldClass, 
                "placeholder"=>""
            ),
            'constraints' => array(
                new Assert\Length(
                    array('min' => 6)
                )
            )
        ));
        
        $builder->add("id", HiddenType::class);
    }
}
