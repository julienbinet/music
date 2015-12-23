<?php	 
// src/Acme/TaskBundle/Form/Type/ArtisteType.php
namespace AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Length;

use PublicBundle\Entity\TagRepository as TagRep ;

class ArtisteType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('nom', 'text', array(
			'constraints' => array(
				new NotBlank(),
				new Length(array('min' => 2)),
				),
			))
		->add('file', 'file')
		->add('pays', 'country',array(
			'empty_value' => 'Choisissez un pays',
			'required'=> true,
			))
		->add('bio', 'textarea' )
		->add('tags', 'entity', array(
			'class' => 'PublicBundle:Tag', 
			'property' => 'nom', 
			'empty_value' => 'Choisissez une catégorie', 
			'expanded' => true,
			'multiple' => true,

			'query_builder' => function(TagRep  $er) {
				return $er->createQueryBuilder('u')
				->orderBy('u.nom', 'ASC');
			},

			))
		->add('Enregistrer', 'submit')
		->getForm();



	}

	public function getName()
	{
		return 'artiste_ajout';
	}
}