<?php

namespace PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AlbumController extends Controller {

    /**
     * 
     * @Route("/albums", name="public.albums")
     * @Template("PublicBundle:Public:albums.html.twig")
     * @Method({"GET"})
     */
    public function indexAction() {

        $em = $this->getDoctrine()->getManager();
        $albums = $em->getRepository("PublicBundle:Album")->findBy(array(), array('nom'=>'asc'));
        $tags = $em->getRepository("PublicBundle:Tag")->findBy(array(), array('nom'=>'asc'));

        return  array(
          'albums' => $albums,
          'tags' => $tags,
          );
    }




    /**
     * 
     * @Route("/album/{id_album}", name="public.album")
     * @Template("PublicBundle:Public:fiche_album.html.twig")
     * @Method({"GET"})
     */
    public function albumAction($id_album) {

      $album = $this
      ->getDoctrine()
      ->getRepository("PublicBundle:Album")
      ->findOneBy(
        array(
          'id' => $id_album,
          ));




      return array(
        'album' => $album,
        );
    }

  }
