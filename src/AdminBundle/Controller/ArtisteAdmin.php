<?php

namespace AdminBundle\Controller;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ArtisteAdmin extends Admin {

    protected function configureFormFields(FormMapper $formMapper) {

        $formMapper->with('Contenu')
                ->add('nom', 'text')
                ->add('bio', 'textarea')
                ->add('pays', 'country')
                ->add('file', 'file', array(
                    'required' => false
                ))
                ->end();
        $formMapper->with('Autre')
                ->add('tags', 'entity', array(
                    'class' => 'PublicBundle\Entity\Tag',
                    'property' => 'nom',
                    'multiple' => true,
                ))
                ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('nom')
                ->add('tags', null, array(), 'entity', array(
                    'class' => 'PublicBundle\Entity\Tag',
                    'property' => 'nom',
        ));
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('nom');
        $listMapper->add('pays');
        $listMapper->add('tags')
                ->add('_action', 'actions', array(
                    'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                        'delete' => array(),
                    )
        ));
    }

    protected function configureShowFields(ShowMapper $showMapper) {

        $showMapper
                ->add('nom', 'text')
                ->add('bio', 'textarea')
                ->add('pays', 'country')
                ->add('image', null,array('template' => 'AdminBundle:Admin:admin_image.html.twig'))
                ->add('tags', 'entity', array(
                    'class' => 'PublicBundle\Entity\Tag',
                    'property' => 'nom',
                ))
        ;
    }

    public function prePersist($image) {
        $this->manageFileUpload($image);
    }

    public function preUpdate($image) {
        $this->manageFileUpload($image);
    }

    private function manageFileUpload($image) {
        $image->refreshUpdated();
    }

}
