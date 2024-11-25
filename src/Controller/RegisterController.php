<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController 
{
    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response 
    {
        $user = new User(); 
        $form = $this->createForm(RegisterUserType::class, $user);
        

        $form->handleRequest($request); // ecoute ce que l utilisateur soumets dans le formulaire afin de mapper / lier / imbriquer les elements entre eux donc entre l'entité et ce que l utilisateur viens de soumettre dans le formulaire

        if($form->isSubmitted() && $form->isValid()){ // est ce que le formulaire est soumis et est valide ? si oui ...
            $entityManager->persist($user); // fige la data, recupere la // le persist() ce fera lors de la creation vers la bdd // on ne fige pas les data deja existant souvent vue via la ligne de code $user = $this->getUser(); par exemple
            $entityManager->flush(); // pousse la dans la bdd, insert la 
            $this->addFlash(
                'success',
                "Bienvenu dans notre boutique, veuillez vous connecter."
            );
            return $this->redirectToRoute('app_login');
        }

        return $this->render('register/index.html.twig', [
            'register_form' => $form->createView()
        ]);
    }
}
