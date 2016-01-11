<?php

namespace AdminBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Description of ArtisteRestController
 *
 * @author julien
 */
class ArtisteRestController extends Controller{

    public function getUserAction($username) {
        
    $user = $this->getDoctrine()->getRepository('AdminBundle:User')->findOneByUsername($username);

        if (!is_object($user)) {
            throw $this->createNotFoundException();
        }
        return $user;
    }

}
