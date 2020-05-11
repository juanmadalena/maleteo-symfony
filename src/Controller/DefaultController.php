<?php

namespace App\Controller;

use App\Entity\Guardian;
use App\Entity\Leads;
use App\Form\LeadsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

     /**
      * @Route("/maleteo", name="landing")
      */

      public function newLead(Request $request, EntityManagerInterface $em){

        $post = new Leads();
        
        $form = $this->createForm(LeadsType::class, $post);
        
        $form->handleRequest($request);
        
        $repo = $em->getRepository(Guardian::class);
        $guardianes = $repo->findBy([
            'ciudad'=>'madrid']
        );


        if ($form->isSubmitted() && $form->isValid()){
            
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->render('thanks.html.twig');


        };

        return $this->render("base.html.twig",
        [ 'form_leads'=>$form->createView(),
            'guardianes'=>$guardianes]);

      }
      /**
       * @Route("/thanks", name="thanks")
       */

       public function thanks(EntityManagerInterface $em){
        $repo=$em->getRepository(Leads::class);
        $nombre = $repo;

       return $this->generateUrl('thanks');
       }

      /**
       * @Route("/admin/solicitudes", name="solicitudes")
       */

      public function solicitudes(EntityManagerInterface $em){

        $repo=$em->getRepository(Leads::class);
        $nombres=$repo->findAll();

        return $this->render('solicitudes.html.twig',[
            'nombres'=>$nombres
        ]);
      }

}   