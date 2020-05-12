<?php

namespace App\Controller;

use App\Entity\Guardian;
use App\Entity\Leads;
use App\Entity\User;
use App\Form\LeadsType;
use App\Security\LoginFormAuthAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        $guardianes = $repo->findBy(
            [
                'ciudad' => 'madrid'
            ]
        );


        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->render('thanks.html.twig');
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

        return $this->generateUrl('thanks');
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
     * @Route('/registro', name='registro')
     */

    // public function registro(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guard, LoginFormAuthAuthenticator $formAuth, EntityManagerInterface $em)
    // {
    //     if ($request->isMethod('POST')){
    //         $usuario= new User();
    //         $usuario->setEmail($request->request->get('email'));
    //         $usuario->setPassword($passwordEncoder->encodePassword($usuario,$request->request->get('password')));
    //         $em->persist($usuario);
    //         $em->flush();
            
    //         return $guard->authenticateUserAndHandleSuccess($usuario, $request, $formAuth, 'main');
    //     }
    //     return $this->render('registro.html.twig',[]);
    // }
}
