<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]

    public function listProducts (): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/product/{id}', name: 'product_view')]
    public function viewProduct ($id): Response
    {
        return $this->render('product/view.html.twig', [
            'controller_name' => 'ProductController',
            'id' => $id
        ]);
    }
}