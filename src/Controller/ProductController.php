<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Slug;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function listProducts(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/product/slug', name: 'product_view_slug')]
    public function slugProducts(Slug $slug): Response
    {
        $text = $slug->slugify('Hello World');

        return $this->render('product/slug.html.twig', [
            'text' => $text
        ]);
    }

    #[Route('/product/{id</d+>}', name: 'product_view')]
    public function viewProduct(int $id): Response
    {
        return $this->render('product/view.html.twig', [
            'controller_name' => 'ProductController',
            'id' => $id
        ]);
    }
}
