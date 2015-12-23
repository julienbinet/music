<?php	 
// src/Acme/TaskBundle/Form/Type/AlbumType.php
namespace AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Length;

use PublicBundle\Entity\ArtisteRepository as ArtisteRep ;

class AlbumType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('idArtiste', 'entity', array(
			'class' => 'PublicBundle:Artiste', 
			'data_class' => 'PublicBundle\Entity\Artiste', 
			'property' => 'nom', 
			'empty_value' => 'Choisissez un artiste', 
			'query_builder' => function(ArtisteRep  $er) {
				return $er->createQueryBuilder('u')
				->orderBy('u.nom', 'ASC');
			},

			))
		->add('nom', 'text', array(
			'constraints' => array(
				new NotBlank(),
				new Length(array('min' => 2)),
				),
			))
		->add('file', 'file')
		->add('dateSortie', 'date', array(
			'input'  => 'datetime',
			'widget' => 'choice',
			'years' => range(1950, date('Y'))
			))
		->add('chansons', 'textarea' )
		->add('infos', 'textarea' )
		->add('Enregistrer', 'submit')
		->getForm();



	}

	public function getName()
	{
		return 'album_ajout';
	}
}