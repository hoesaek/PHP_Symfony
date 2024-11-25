<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    /**
     * Affiche les informations d'une catégorie spécifique.
     *
     * Cette fonction gère une route dynamique qui récupère une catégorie
     * basée sur son slug. Elle utilise le `CategoryRepository` pour trouver 
     * la catégorie correspondante dans la base de données, puis rend une 
     * vue Twig avec les détails de cette catégorie.
     *
     * @param string $slug Le slug de la catégorie à afficher.
     * @param CategoryRepository $categoryRepository Le service permettant d'accéder aux données des catégories.
     * 
     * @return Response La page affichant les détails de la catégorie.
    */
    #[Route('/categorie/{slug}', name: 'app_category')]
    public function index($slug, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBySlug($slug);

        return $this->render('category/index.html.twig', [
            'category' => $category
        ]);
    }
}
