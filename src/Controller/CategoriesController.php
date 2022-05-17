<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    #[Route('/categories/create', name: 'categories')]
    public function index(Request $request): Response
    {
        $category = new Categories();
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('dashboard');
        }
        return $this->render('categories/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    #[Route('/categories', name: 'categories')]
    public function getAll(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository(Categories::class)->AllCategories();
        return $this->render('categories/all.html.twig', [
            'posts' => $posts
        ]);
    }
}
