<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\Common\Util\Debug as Debug;

use AdminBundle\Form\Type\ArtisteType;
use PublicBundle\Entity\Artiste;

/**
 * @Route("/admin/artistes")
 */

class ArtisteController extends Controller
{

	 /**
     * @Route("/ajout", name="admin.artiste.ajout")
     * @Template("AdminBundle:Admin:artiste-ajout.html.twig")
     * @Method({"GET", "POST"})
     */
  public function ajoutAction(Request $request)
  {

    $em = $this->getDoctrine()->getManager();
    $artiste = new Artiste();
    $type = new ArtisteType();
    $form = $this->createForm($type, $artiste);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

     $data = $form->getData();
     $artiste->upload();
     $em->persist($data);
             // echo "<pre>", Debug::dump($data);echo "</pre>"; exit();
     $em->flush();

     $request->getSession()->getFlashBag()->set('notice', 'L\'artiste a été ajouté !');

            //ajout message flush
     return $this->redirect(
      $this->generateUrl('admin.home')
      );

   }else{
    return array( 
      'form' => $form->createView() 
      );
  }

}

   /**
     * @Route("/", name="admin.artiste.index")
     * @Template("AdminBundle:Admin:artistes.html.twig")
     * @Method({"GET", "POST"})
     */
   public function indexAction(Request $request)
   {

    $em = $this->getDoctrine()->getManager();
    $artistes = $em->getRepository("PublicBundle:Artiste")->findBy(array(), array('nom'=>'asc'));

    return  array(
      'artistes' => $artistes,
      );
  }


    /**
     * 
     * @Route("/voir/{id_artiste}", name="admin.artiste.voir")
     * @Template("AdminBundle:Admin:fiche_artiste.html.twig")
     * @Method({"GET"})
     */
    public function voirAction($id_artiste) {

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



      return  array(
        'artiste' => $artiste,
        'albums' => $albums,
        );
    }


    /**
     * 
     * @Route("/edit/{id_artiste}", name="admin.artiste.edit")
     * @Template("AdminBundle:Admin:artiste-edit.html.twig")
     * @Method({"GET", "POST"})
     */
    public function editAction($id_artiste) {


      $artiste = $this
      ->getDoctrine()
      ->getRepository("PublicBundle:Artiste")
      ->findOneBy(
        array(
          'id' => $id_artiste,
          ));

      $em = $this->getDoctrine()->getEntityManager();

      $form = $this->createForm(new ArtisteType(), $artiste);

      $request = $this->getRequest();

      if ($request->isMethod('POST')) {
       $form->handleRequest($request);
       if ($form->isValid()) {
        $a = $form->getData();
        $a->upload();

        $em->persist($a);
        $em->flush();

        $request->getSession()->getFlashBag()->set('notice', 'L\'artiste a été modifié !');

        return $this->redirect(
          $this->generateUrl('admin.home')
          );
      }
    }
    return array(
      'id' => $id_artiste,
      'form' => $form->createView(),
      );

  }



    /**
     * 
     * @Route("/delete/{id_artiste}", name="admin.artiste.delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction($id_artiste) {


     $artiste = $this
     ->getDoctrine()
     ->getRepository("PublicBundle:Artiste")
     ->findOneBy(
      array(
        'id' => $id_artiste,
        ));


     $em = $this->getDoctrine()->getEntityManager();

     $form = $this->createForm(new ArtisteType(), $artiste);

     $request = $this->getRequest();

     if ($request->isMethod('POST')) {
       $form->handleRequest($request);

       $em->remove($artiste);
       $em->flush();

       $request->getSession()->getFlashBag()->set('notice', 'L\'artiste a été supprimé !');

       return $this->redirect(
        $this->generateUrl('admin.home')
        );
     }
       return $this->redirect(
        $this->generateUrl('admin.artiste.index')
        );



   }










 }
