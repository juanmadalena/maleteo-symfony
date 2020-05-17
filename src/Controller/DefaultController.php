<?php

namespace App\Controller;

use App\Entity\Guardian;
use App\Entity\Leads;
use App\Entity\User;
use App\Form\LeadsType;
use App\Form\OpinionesType;
use App\Form\RegistroType;
use App\Security\LoginFormAuthAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class DefaultController extends AbstractController
{

    /**
     * @Route("/maleteo", name="landing")
     */

    public function newLead(Request $request, EntityManagerInterface $em)
    {

        $post = new Leads();

        $form = $this->createForm(LeadsType::class, $post);

        $form->handleRequest($request);

        $repo = $em->getRepository(Guardian::class);
        $guardianes = $repo->findAll();


        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->render("thanks.html.twig");
        };

        return $this->render(
            "base.html.twig",
            [
                'form_leads' => $form->createView(),
                'guardianes' => $guardianes
            ]
        );
    }
    /**
     * @Route("/thanks", name="thanks")
     */

    public function thanks(EntityManagerInterface $em)
    {
        $repo = $em->getRepository(Leads::class);
        $nombre = $repo;

        return $this->render('thanks.html.twig');
    }

    /**
     * @Route("/solicitudes", name="solicitudes")
     * 
     */


    public function solicitudes(EntityManagerInterface $em)
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $repo = $em->getRepository(Leads::class);
        $nombres = $repo->findAll();

        return $this->render('solicitudes.html.twig', [
            'nombres' => $nombres
        ]);
    }

    /**
     * @Route("/registro", name="registro") 
     */

    public function registro(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guard, LoginFormAuthAuthenticator $formAuth, EntityManagerInterface $em){

    $user = new User();
    $formRegistro = $this->createForm(RegistroType::class, $user);

    
    $formRegistro->handleRequest($request);

        if ($formRegistro->isSubmitted() && $formRegistro->isValid()){
            
            $user = $formRegistro->getData();
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $em->persist($user);
            $em->flush();
            
            return $guard->authenticateUserAndHandleSuccess($user, $request, $formAuth, 'main');
        }
        
        return $this->render('registro.html.twig',[
            'registroForm' => $formRegistro->createView()
            ]
        );
    }
    
    /**
     * @Route("solicitudes/borrar/{id}", name="borrarDato")
     */

    public function borrarDato( $id ,EntityManagerInterface $em){
        $solicitud = $em->getRepository(Leads::class);
        $dato = $solicitud->findOneBy([
            'id'=>$id
        ]);

        $em->remove($dato);
        $em->flush();

        return  new RedirectResponse("/solicitudes");

    }

    /**
     * @Route("/opinion", name="opinion")
     */

    public function opiniones(EntityManagerInterface $em, Request $request){

        $guardian = new Guardian();
        $form = $this->createForm(OpinionesType::class,$guardian);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
           
            $em = $this->getDoctrine()->getManager();
            $em->persist($guardian);
            $em->flush();

            return new RedirectResponse("/maleteo");

        }

        return $this->render('opinion.html.twig',[
            'opinionForm' => $form->createView()
        ]);

    }
}
