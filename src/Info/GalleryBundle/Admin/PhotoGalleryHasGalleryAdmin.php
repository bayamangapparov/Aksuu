<?php

namespace Info\GalleryBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PhotoGalleryHasGalleryAdmin extends Admin
{
    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $form
     */



    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $list)
    {
        $list
//            ->add('activity')
            ->add('media')
        ;
    }

//    /**
//     * @param DatagridMapper $datagridMapper
//     */
//    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
//    {
//        $datagridMapper
//            ->add('id')
//        ;
//    }

//    /**
//     * @param ListMapper $listMapper
//     */
//    protected function configureListFields(ListMapper $listMapper)
//    {
//        $listMapper
////            ->add('id')
//            ->add('activity')
//            ->add('media')
//            ->add('_action', 'actions', array(
//                'actions' => array(
//                    'show' => array(),
//                    'edit' => array(),
//                    'delete' => array(),
//                )
//            ))
//        ;
//    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('media', 'sonata_type_model_list', array(), array(
                'link_parameters' => array('context' => 'photo_gallery')
            ))
        ;
    }

//    /**
//     * @param ShowMapper $showMapper
//     */
//    protected function configureShowFields(ShowMapper $showMapper)
//    {
//        $showMapper
//            ->add('id')
//        ;
//    }
}
