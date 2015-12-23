<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * @Route("/admin")
 */

class AdminController extends Controller
{

	 /**
     * @Route("/", name="admin.home")
     * @Template("AdminBundle:Admin:index.html.twig")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        // return $this->render('AdminBundle:Admin:index.html.twig', array('name' => $name));
        return array( );
    }
}
