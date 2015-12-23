<?php

namespace AdminBundle\Controller;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Description of AlbumAdmin
 *
 * @author julien
 */
class AlbumAdmin extends Admin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper->with('Contenu')
                ->add('idArtiste', 'sonata_type_model', array(
                    'class' => 'PublicBundle\Entity\Artiste',
                    'property' => 'nom',
                    'label' => 'Artiste',
                ))
                ->add('nom', 'text')
                ->add('chansons', 'textarea')
                ->add('infos', 'textarea')
                ->add('file', 'file')
                ->add('dateSortie', 'date', array(
                    'format' => "dd MM yyyy",
                    'input' => 'datetime',
                    'widget' => 'choice',
                    'years' => range(date('Y'), 1950)
                    )
                )
                ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('nom')
        /* ->add('tags', null, array(), 'entity', array(
          'class'    => 'PublicBundle\Entity\Tag',
          'property' => 'nom',
          )) */;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('nom');
        $listMapper->add('pays');
//        $listMapper->add('tags');
    }

}
