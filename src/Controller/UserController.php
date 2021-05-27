<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/compte", name="mon-compte")
     */
    public function compte(Request $request, UserPasswordEncoderInterface $encoder, SessionInterface $session):Response{
        // Mise en place du formulaire d'après les informations de l'utilisateur connecté
        $user = $this->getUser();
        if(empty($session->get('password'))){
            $session->set('password', $user->getPassword());
        }
        $form = $this->createForm(UserCompteType::class, $user);
        // On hydrate le formulaire avec les données de la requête
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if(is_null($user->getPassword())){ 
                // On récupère le mot de passe actuel dans la session
                $user->setPassword($session->get('password'));
            }else{   
                $plainPassword = $user->getPassword();
                $encodedPassword = $encoder->encodePassword($user, $plainPassword);
                $user->setPassword($encodedPassword);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash("success", "Vos informations ont bien été mises à jour.");
        }
        
        return $this->render('user/compte.html.twig', ["form"=>$form->createView()]);
    }
    /**
     * @Route("/inscription", name="user-inscription")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        // Mise en place d'un formulaire afin d'en envoyer la vue au twig
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        // On hydrate le formulaire
        $form->handleRequest($request);
        // Si le formulaire est renvoyé et valid quand on passe dans la méthode
        if($form->isSubmitted() && $form->isValid()){
            // On affecte un rôle à l'utilisateur car il n'y a pas de chois de role dans le formulaire
            $user->setRoles(['ROLE_USER']);
            $originePassword = $user->getPassword();
            $encodedPassword = $encoder->encodePassword($user, $originePassword);
            $user->setPassword($encodedPassword);
            //
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // Redirection
            return $this->redirectToRoute('inscription-confirmation');
        }
        //
        return $this->render('user/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/inscription-confirmation", name="inscription-confirmation")
     */
    public function confirmation(){
        return new Response('Inscription ok');
    }
}
