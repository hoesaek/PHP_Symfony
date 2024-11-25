<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Produit')
            ->setEntityLabelInPlural('Produits')
            // ...
        ;
    }
    /**
     * Résumé de configureFields
     * @param string $pageName
     * cette fonction va configurer les differents éléments dans le formulaire crud de Easyadmin
     * @return iterable
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            TextField::new('name')->setLabel('Pruduit')->setHelp('Nom de votre produit'),  
            SlugField::new('slug')->setLabel('Url')->setTargetFieldName('name')->setHelp('URL de votre categorie'),  
            TextareaField::new('description')->setLabel('Description du produit')->setHelp('Description de votre produit'),
            /**
             * Attention a comment est configurer le champs image.
             * setBasePath() se trouve a la racine de mon projet vue que c est que de l'affichage tout comme mes assets donc dans le dossier /public alors que 
             * setUploadDir() c'est du php et je dois definir le chemin complet de l'endroit où sera upload mes images
             * https://symfony.com/bundles/EasyAdminBundle/current/fields/ImageField.html
             */
            ImageField::new('illustration')->setLabel('Image')->setHelp('Image du produit en 600x600')->setUploadedFileNamePattern('[year]-[month]-[day]-[contenthash].[extension]')->setBasePath('/uploads')->setUploadDir('/public/uploads'),
            NumberField::new('price')->setLabel('Prix H.T')->setHelp('Prix de votre produit hors-taxes sans le sigle euro €.'),
            ChoiceField::new('tva')->setLabel('Taux de TVA')->setChoices([
                '5.5%' => '5.5',
                '10%' => '10',
                '20%' => '20',
            ]),
            /**
            * AssociationField va associer les elements de l'entité category au formulaire des produit, attention a bien ajouté une fonction __toString() dans l entité concerner 
            * public function __toString()
            *   {
            *     return $this->name;
            *   }
            * pour qu il puisse gerer le cas ou ce soit non pas un objet qui est appeler mais une chaine de caractere
            */
            AssociationField::new('category', 'Categorie associée')
        ];
    }
    
}
