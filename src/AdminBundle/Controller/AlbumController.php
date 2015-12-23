<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\Common\Util\Debug as Debug;

use AdminBundle\Form\Type\AlbumType;
use PublicBundle\Entity\Album;

/**
 * @Route("/admin/album")
 */

class AlbumController extends Controller
{

	 /**
     * @Route("/ajout", name="admin.album.ajout")
     * @Template("AdminBundle:Admin:album-ajout.html.twig")
     * @Method({"GET", "POST"})
     */
     public function ajoutAction(Request $request)
     {


        $em = $this->getDoctrine()->getManager();
        $album = new Album();
        $type = new AlbumType();
        $form = $this->createForm($type, $album);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

         $data = $form->getData();

         $album->upload();

         $em->persist($data);

             // echo "<pre>", Debug::dump($data);echo "</pre>"; exit();
         $em->flush();


         $request->getSession()->getFlashBag()->set('notice', 'L\'Album a été ajouté !');

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
     * @Route("/", name="admin.album.index")
     * @Template("AdminBundle:Admin:albums.html.twig")
     * @Method({"GET", "POST"})
     */
   public function indexAction(Request $request)
   {

  
        $em = $this->getDoctrine()->getManager();
        $albums = $em->getRepository("PublicBundle:Album")->findBy(array(), array('nom'=>'asc'));

        return  array(
          'albums' => $albums,
          );
  }


    /**
     * 
     * @Route("/voir/{id_album}", name="admin.album.voir")
     * @Template("AdminBundle:Admin:fiche_album.html.twig")
     * @Method({"GET"})
     */
    public function voirAction($id_album) {

      $album = $this
      ->getDoctrine()
      ->getRepository("PublicBundle:Album")
      ->findOneBy(
        array(
          'id' => $id_album,
          ));

      return  array(
        'album' => $album,
        );
    }


    /**
     * 
     * @Route("/edit/{id_album}", name="admin.album.edit")
     * @Template("AdminBundle:Admin:album-edit.html.twig")
     * @Method({"GET", "POST"})
     */
    public function editAction($id_album) {


      $album = $this
      ->getDoctrine()
      ->getRepository("PublicBundle:Album")
      ->findOneBy(
        array(
          'id' => $id_album,
          ));

      $em = $this->getDoctrine()->getEntityManager();

      $form = $this->createForm(new AlbumType(), $album);

      $request = $this->getRequest();

      if ($request->isMethod('POST')) {
       $form->handleRequest($request);
       if ($form->isValid()) {
        $a = $form->getData();
        $a->upload();

        $em->persist($a);
        $em->flush();

        $request->getSession()->getFlashBag()->set('notice', 'L\'album a été modifié !');

        return $this->redirect(
          $this->generateUrl('admin.home')
          );
      }
    }
    return array(
      'id' => $id_album,
      'form' => $form->createView(),
      );

  }



    /**
     * 
     * @Route("/delete/{id_album}", name="admin.album.delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction($id_album) {


     $album = $this
     ->getDoctrine()
     ->getRepository("PublicBundle:Album")
     ->findOneBy(
      array(
        'id' => $id_album,
        ));


     $em = $this->getDoctrine()->getEntityManager();

     $form = $this->createForm(new AlbumType(), $album);

     $request = $this->getRequest();

     if ($request->isMethod('POST')) {
       $form->handleRequest($request);

       $em->remove($album);
       $em->flush();

       $request->getSession()->getFlashBag()->set('notice', 'L\'album a été supprimé !');

       return $this->redirect(
        $this->generateUrl('admin.home')
        );
     }
       return $this->redirect(
        $this->generateUrl('admin.album.index')
        );



   }









}
