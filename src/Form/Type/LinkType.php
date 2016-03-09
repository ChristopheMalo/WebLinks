<?php

namespace WebLinks\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class to manage link form
 * 
 *
 * @author      Christophe Malo
 * @date        05/02/2016
 * @version     1.0.0
 * @copyright   OpenClassrooms - Baptiste Pesquet
 */
class LinkType extends AbstractType
{
    
    /**
     * Builds the form
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('title', 'text')
                ->add('url', 'text');
    }
    
    /**
     * Gets the name of the form
     * 
     * @return string
     */
    public function getName()
    {
        return 'link';
    }
    
}
