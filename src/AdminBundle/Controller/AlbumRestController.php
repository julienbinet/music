<?php

namespace AdminBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use PublicBundle\Entity\Album;
use PublicBundle\Entity\AlbumRepository;

/**
 * Description of AlbumRestController
 *
 * @author julien
 */
class AlbumRestController extends Controller {

    /**
     * 
     * @return array
     * @View(serializerEnableMaxDepthChecks=true)
     * 
     */
    public function getAlbumsAction() {

        $albums = $this->getDoctrine()->getRepository('PublicBundle:Album')->findAll();
        return array("albums" => $albums);
    }

    /**
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function getAlbumAction($id) {
        $album = $this->getDoctrine()->getRepository('PublicBundle:Album')->findOneBy(array('id' => $id));
        return $album;
    }

}
