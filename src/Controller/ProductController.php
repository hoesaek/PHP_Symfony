<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/produit/{slug}', name: 'app_product')]
    public function index($slug, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findOneBySlug($slug);

        if(!$product){
            $this->addFlash(
                'danger',
                "Le produit que vous essayez de rechercher n'est pas disponible ou n'existe pas"
            );
            return $this->redirectToRoute('app_home');
        }

        return $this->render('product/index.html.twig', [
            'product' => $product,
        ]);
    }
}
