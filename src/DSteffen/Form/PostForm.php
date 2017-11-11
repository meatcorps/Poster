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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Form Template for the post form. 
 *
 * @author Dennis Steffen
 */
class PostForm extends AbstractType implements FormTypeInterface {
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
        $builder->add("title", TextType::class, array(
            "label" => "Title (Minimal length is 2)", 
            "required" => true, 
            "attr"=> array(
                "class" =>$this->fieldClass,
                "placeholder"=>"Title"
            ),
            'constraints' => array(
                new Assert\NotBlank(), 
                new Assert\Length(
                    array('min' => 2)
                )
            )
        ));
        
        $builder->add("message", TextareaType::class, array(
            "label"=>"Message", 
            "required"=> true, 
            "attr"=> array(
                "class"=>$this->fieldClass . " tinymce", 
                "placeholder"=>"Message"
            )
        ));
        
        $builder->add("author", TextType::class, array(
            "label"=>"Author (Minimal length is 5)", 
            "required"=> true, 
            "attr"=> array(
                "class"=>$this->fieldClass, 
                "placeholder"=>"Author"
            ),
            'constraints' => array(
                new Assert\NotBlank(), 
                new Assert\Length(
                    array('min' => 5)
                )
            )
        ));
        
        $builder->add("id", HiddenType::class);
    }
}
