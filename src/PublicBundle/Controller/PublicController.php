<?php

namespace PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class PublicController extends Controller
{

	 /**
     * @Route("/", name="public.home")
     * @Template("PublicBundle:Public:index.html.twig")
     * @Method({"GET"})
     */
     public function indexAction()
     {


        $em = $this->getDoctrine()->getManager();
        $artistes = $em->getRepository("PublicBundle:Artiste")->findBy(array(), array('nom'=>'asc'));
        $tags = $em->getRepository("PublicBundle:Tag")->findBy(array(), array('nom'=>'asc'));

        return  array(
          'artistes' => $artistes,
          'tags' => $tags,
          );


    }
}
