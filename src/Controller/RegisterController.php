<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $user->setPassword($passwordHasher->hashPassword($user,$form['password']->getData()));
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('success');
        }
        return $this->render('register/index.html.twig', [
            'controller_name' => 'RegisterController',
            'formulario' => $form->createView()
        ]);




    }



    #[Route('/success', name: 'success')]
    public function success()
    {

        return $this->render('register/success.html.twig', [
            'controller_name' => 'RegisterController',

        ]);




    }
}
