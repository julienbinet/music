<?php

namespace AdminBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use PublicBundle\Entity\Artiste;
use PublicBundle\Entity\ArtisteRepository;

/**
 * Description of ArtisteRestController
 *
 * @author julien
 */
class ArtisteRestController extends Controller {

    /**
     * 
     * @return array
     * @View()
     * 
     */
    public function getArtistesAction() {

        $artistes = $this->getDoctrine()->getRepository('PublicBundle:Artiste')->findAll();
        return array("artistes" => $artistes);
    }

    /**
     * @View()
     */
    public function getArtisteAction($id) {
        $artiste = $this->getDoctrine()->getRepository('PublicBundle:Artiste')->findOneBy(array('id' => $id));
        return $artiste;
    }

}
