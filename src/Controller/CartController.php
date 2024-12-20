<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    /**
     * Affiche le panier actuel.
     *
     * @param Cart $cart Le service représentant le panier.
     * @return Response La vue contenant le contenu du panier.
    */
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Cart $cart): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getCart()
        ]);
    }

    /**
     * Ajoute un produit au panier.
     * redirect($request->headers->get('referer') : me permet d etre redirigé vers le dernier url visiter 
     * @param int $id L'identifiant du produit à ajouter.
     * @param Cart $cart Le service représentant le panier.
     * @param ProductRepository $productRepository Le repository permettant de récupérer le produit.
     * @param Request $request L'objet Request pour gérer la redirection.
     * @return Response Une redirection vers la page précédente.
    */
    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add($id, Cart $cart, ProductRepository $productRepository, Request $request): Response
    {
        $produit = $productRepository->findOneById($id);

        $cart->add($produit);

        // $this->addFlash(
        //     'success',
        //     "Produit correctement ajouté à mon panier"
        // );

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/cart/decrease/{id}', name: 'app_cart_decrease')]
    public function decrease($id, Cart $cart): Response
    {

        $cart->decrease($id);

        // $this->addFlash(
        //     'success',
        //     "Produit correctement retiré à mon panier"
        // );

        return $this->redirectToRoute('app_cart');
    }

    /**
     * Vide le panier.
     *
     * @param Cart $cart Le service représentant le panier.
     * @return Response La vue de la page d'accueil après avoir vidé le panier.
    */
    #[Route('/cart/remove', name: 'app_cart_remove')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();

        return $this->render('home/index.html.twig');
    }

}
