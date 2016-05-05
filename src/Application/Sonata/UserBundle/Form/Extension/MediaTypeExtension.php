<?php
namespace Application\Sonata\UserBundle\Form\Extension;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class MediaTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'show_unlink' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        if (!$options['show_unlink']) {
            $builder->add('unlink', 'hidden', array(
                'mapped'   => false,
                'data'     => false,
                'required' => false,
            ));
        }
//    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
//        die();
        return 'sonata_media_type';
    }

}