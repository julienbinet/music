<?php

namespace AdminBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * Description of UserRestController
 *
 * @author julien
 */
class UserRestController extends Controller {

    /**
     * 
     * @return array
     * @View()
     * 
     */
    public function getUsersAction() {

//    $user = $this->getDoctrine()->getRepository('AdminBundle:User')->findOneByUsername($username);
        
          $user = $this->getDoctrine()->getRepository('AdminBundle:User')->findAll();
          return array("users" => $user);

    }

}
