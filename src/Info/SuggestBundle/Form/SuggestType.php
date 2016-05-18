<?php

namespace Info\SuggestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SuggestType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('phonenumber')
            ->add('email', 'email')
            ->add('message')
            ->add('captcha', 'captcha', array('attr'=>array('placeholder'=>'')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Info\SuggestBundle\Entity\Suggest'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'info_suggestbundle_suggest';
    }
}
