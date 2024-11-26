<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{

    /**
     * Classe gérant les opérations sur le panier via la session.
     * se referer a la doc : https://symfony.com/doc/current/session.html
    */
    public function __construct(private RequestStack $requestStack) {

        // Accéder à la session dans le constructeur n'est pas recommandé, 
        // car cela pourrait entraîner des effets secondaires indésirables.
        // $this->session = $requestStack->getSession();
    }

    /**
     * Ajoute un produit au panier.
     * deux maniere de proceder pour la condition de la quatité de mon panier avec soit 
     * $cart[$product->getId()] = [
     *       'objet' => $product,
     *       'qty' => isset($cart[$product->getId()]) ? $cart[$product->getId()]['qty'] + 1 : 1
     * ];
     * ou alors l element retenue dans ma fonction
     * @param mixed $product Le produit à ajouter au panier.
     * @return void
    */
    public function add($product){

        //afin de ne pas ecraser le produit precedent dans mon panier :
        $cart = $this->requestStack->getSession()->get('cart');

        //ajouter une quantité +1 de mon produit dans le panier
        if (isset($cart[$product->getId()])) {
            $cart[$product->getId()] = [
                'objet' => $product,
                'qty' => $cart[$product->getId()]['qty'] + 1
            ];
        } else {
            $cart[$product->getId()] = [
                'objet' => $product,
                'qty' => 1
            ];
        }
        
        // creer ma session carte afin de pouvoir recuperer ces informations pour l'ajout
        // suivant
        $this->requestStack->getSession()->set('cart', $cart);

    }

    /**
     * Récupère le contenu actuel du panier.
     *
     * @return array|null Le panier ou null s'il n'existe pas.
    */
    public function getCart(){
        return $this->requestStack->getSession()->get('cart');
    }

    /**
     * Calcule le nombre total d'articles dans le panier en cours si non null.
     *
     * @return int Le nombre total d'articles.
    */
    public function countQty()
    {
        $totalQty = 0;

        if($this->requestStack->getSession()->get('cart')){
            foreach ($this->requestStack->getSession()->get('cart') as $item) {
                $totalQty += $item['qty'];
            }

        }else{
            $totalQty = 0;
        }
        return $totalQty;
    }

    /**
     * Vide le panier.
     *
     * @return void
    */
    public function remove(){
       return $this->requestStack->getSession()->remove('cart');
    }

    public function decrease($id){

        $cart = $this->requestStack->getSession()->remove('cart');

        //si jamais ma quatité dans le panier est > 1 alors qty -1 mais si il est = a 1 alors je le retire de mon panier

        if($cart[$id]['qty'] > 1){
           $cart[$id]['qty'] = $cart[$id]['qty'] - 1;
        }else{
            //remove de mon panier le produit
            unset($cart[$id]);
        }
        
        // creer ma session carte afin de pouvoir recuperer ces informations pour l'ajout
        // suivant
        $this->requestStack->getSession()->set('cart', $cart);

    }

}
