<?php

namespace Info\GalleryBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PhotoGalleryAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
//            ->add('title')
            ->add('createDate')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('title')
            ->add('createDate')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('translations', 'a2lix_translations', array(
                'fields' => array('title' => array('label' => 'Название альбома'))
            ))
            ->add('cover', 'file', array(
                'multiple' => true,
                'data_class' => null,
            ))
//            ->add('cover', 'sonata_type_model_list', array(), array(
//                'link_parameters' => array(
//                    'context' => 'cover_photo_gallery',
//                    'provider' => 'sonata.media.provider.image',
//                    'required' => false,
//                ),
//            ))
            ->add('photoGalleryHasGalleries', 'sonata_type_collection', array(
                'type_options' => array('delete' => false),

                'cascade_validation' => true), array(
                'edit' => 'inline',
                'inline' => 'table',
                'link_parameters' => array(
                    'context' => 'photo_gallery',
                ),
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
//            ->add('title')
            ->add('createDate')
        ;
    }
}
