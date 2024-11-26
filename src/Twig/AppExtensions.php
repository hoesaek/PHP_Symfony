<?php

namespace App\Twig;

use App\Classe\Cart;
use App\Repository\CategoryRepository;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

class AppExtensions extends AbstractExtension implements GlobalsInterface
{

    private $categoryrepository;
    private $currentqtycart;

    public function __construct(CategoryRepository $categoryRepository, Cart $cart){
        $this->categoryrepository = $categoryRepository;
        $this->currentqtycart = $cart;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('price',[ // le nom du filtre que j utiliserai
                $this, //l objet concerner par la fonction
                'formatPrice' // la fonction appeler
            ])
        ];
    }

    public function formatPrice($number){

        return number_format($number, '2',','). ' €';
    }

    public function getGlobals() : array {
        return [
            'allCategories' => $this->categoryrepository->findAll(),
            'allQty' => $this->currentqtycart->countQty()
        ];
    }

}