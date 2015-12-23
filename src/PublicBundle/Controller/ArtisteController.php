<?php

namespace PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ArtisteController extends Controller {

    /**
     * 
     * @Route("/artistes", name="public.artistes")
     * @Template("PublicBundle:Public:artistes.html.twig")
     * @Method({"GET"})
     */
    public function indexAction() {

        $em = $this->getDoctrine()->getManager();
        $artistes = $em->getRepository("PublicBundle:Artiste")->findBy(array(), array('nom'=>'asc'));
        $tags = $em->getRepository("PublicBundle:Tag")->findBy(array(), array('nom'=>'asc'));

        return  array(
          'artistes' => $artistes,
          'tags' => $tags,
          );
    }




    /**
     * 
     * @Route("/artiste/{id_artiste}", name="public.artiste")
     * @Template("PublicBundle:Public:fiche_artiste.html.twig")
     * @Method({"GET"})
     */
    public function artisteAction($id_artiste) {

      $artiste = $this
      ->getDoctrine()
      ->getRepository("PublicBundle:Artiste")
      ->findOneBy(
        array(
          'id' => $id_artiste,
          ));


      $albums = $this
      ->getDoctrine()
      ->getRepository("PublicBundle:Album")
      ->findBy(
        array(
          'idArtiste' => $id_artiste,
          ));


      return array(
        'artiste' => $artiste,
        'albums' => $albums,
        );
    }

  }
