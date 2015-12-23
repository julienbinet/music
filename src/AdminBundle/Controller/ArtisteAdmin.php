<?php

namespace AdminBundle\Controller;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ArtisteAdmin extends Admin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper->with('Contenu')
                ->add('nom', 'text')
                ->add('bio', 'textarea')
                ->add('pays', 'country')
                ->add('file', 'file')
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
                'class'    => 'PublicBundle\Entity\Tag',
                'property' => 'nom',
            ));
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('nom');
        $listMapper->add('pays');
        $listMapper->add('tags');
    }

}
