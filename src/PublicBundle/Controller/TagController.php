<?php

namespace PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class TagController extends Controller {

    /**
     * 
     * @Route("/genre/{id_tag}", name="public.genre")
     * @Template("PublicBundle:Public:genre.html.twig")
     * @Method({"GET"})
     */
    public function voirAction($id_tag) {

      $em = $this->getDoctrine()->getManager();

//utiliser les repository;

      $repository = $this->getDoctrine()
      ->getManager()
      ->getRepository('PublicBundle:Artiste');

      $artistes = $repository->getArtistes($id_tag);
$tags = $em->getRepository("PublicBundle:Tag")->findBy(array(), array('nom'=>'asc'));

      $tag = $this
      ->getDoctrine()
      ->getRepository("PublicBundle:Tag")
      ->findOneBy(
        array(
          'id' => $id_tag,
          ));

      return array(
        'artistes' => $artistes,
        'tag' => $tag,
        'tags' => $tags,
        );
    }

  }
