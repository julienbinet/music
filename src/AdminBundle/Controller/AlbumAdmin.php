<?php

namespace AdminBundle\Controller;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Description of AlbumAdmin
 *
 * @author julien
 */
class AlbumAdmin extends Admin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper->with('Contenu')
                ->add('nom', 'text')
                ->add('chansons', 'textarea')
                ->add('infos', 'textarea')
                ->add('file', 'file', array(
                    'required' => false
                ))
                ->add('dateSortie', 'date', array(
                    'format' => "dd MM yyyy",
                    'input' => 'datetime',
                    'widget' => 'choice',
                    'years' => range(date('Y'), 1950)
                        )
                )
                ->add('artiste', 'entity', array(
                    'class' => 'PublicBundle\Entity\Artiste',
                    'property' => 'nom',
                    'multiple' => false,
                ))
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
        $listMapper->add('dateSortie');
        $listMapper->add('artiste.nom')
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
                ->add('chansons', 'textarea')
                ->add('infos', 'textarea')
                ->add('image', null, array('template' => 'AdminBundle:Admin:admin_image.html.twig'))
                ->add('dateSortie', 'date', array(
                    'format' => "d M Y",
                        )
                )
                ->add('artiste.nom', 'entity', array(
                    'class' => 'PublicBundle\Entity\Artiste',
                    'property' => 'bio',
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
