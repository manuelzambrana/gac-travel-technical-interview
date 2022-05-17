<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    #[Route('/products/create', name: 'products-create')]
    public function index(Request $request): Response
    {
        $product = new Products();
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('dashboard');
        }
        return $this->render('products/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/products', name: 'products')]
    public function getAll(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository(Products::class)->AllProducts();
        return $this->render('products/all.html.twig', [
            'posts' => $posts
        ]);
    }
}
