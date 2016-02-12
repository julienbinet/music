<?php

namespace AdminBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use PublicBundle\Entity\Tag;
use PublicBundle\Entity\TagRepository;

/**
 * Description of ArtisteRestController
 *
 * @author julien
 */
class TagRestController extends Controller {

    /**
     * 
     * @return array
     * @View(serializerEnableMaxDepthChecks=true)
     * 
     */
    public function getTagsAction() {

        $tags = $this->getDoctrine()->getRepository('PublicBundle:Tag')->findAll();
        return array("tags" => $tags);
    }

    /**
     * @View(serializerEnableMaxDepthChecks=true)
     */
    public function getTagAction($id_tag) {


        // $tag = $this->getDoctrine()->getRepository('PublicBundle:Tag')->findOneBy(array('nom' => $name));
        /* faire la liaison pour récupérer tout les artistes du genre */

        $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('PublicBundle:Artiste');

        $artistes = $repository->getArtistes($id_tag);
  



        return $artistes;
    }

}
