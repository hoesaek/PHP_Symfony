<?php

namespace App\Controller;

use App\Service\MarkdownParser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarkdownController extends AbstractController
{
    #[Route('/privacy_terms', name: 'app_privacy_terms')]
    public function showAll(MarkdownParser $markdownParser): Response
    {
        // Chemin du dossier contenant les fichiers Markdown
        $directoryPath = $this->getParameter('kernel.project_dir') . '/public/docs/';

        if (!is_dir($directoryPath)) {
            throw $this->createNotFoundException('Le dossier Markdown n\'existe pas.');
        }

        // Récupérer tous les fichiers .md du répertoire
        $markdownFiles = glob($directoryPath . '*.md');

        if (empty($markdownFiles)) {
            throw $this->createNotFoundException('Aucun fichier Markdown trouvé.');
        }

        $htmlContents = '';

        // Lire et convertir chaque fichier Markdown
        foreach ($markdownFiles as $filePath) {
            $htmlContents .= '<br><br>';
            
            $markdownContent = file_get_contents($filePath);
            $htmlContents .= $markdownParser->parse($markdownContent);
            
        }

        // Rendre le contenu dans Twig
        return $this->render('markdown/index.html.twig', [
            'htmlContents' => $htmlContents,
        ]);
    }
}
