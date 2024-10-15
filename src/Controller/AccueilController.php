<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController
{
    #[Route("/", name: "accueil", methods: ["GET"])]
    public function accueil()
    {
        return new Response("<h1>salut tous le monde !</h1>", 
        Response::HTTP_OK);
    }
}

// creer un controller avec :
// une action pour afficher un nombre aléatoire entre 0 et 1000
// une action qui affiche la date du jour
