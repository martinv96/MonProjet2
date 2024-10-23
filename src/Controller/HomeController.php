<?php 

namespace App\Controller;

use App\Repository\AuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {
    #[Route("/home", name: "home")]

    function home(AuteurRepository $auteurRepo) {
        $auteurs = $auteurRepo->findAll();

        $prenom = 'martin';
        $nom = 'vallée';
        $notes = [
            'math' => 12,
            'physique' => 17,
            'informatique' => 18,
            'Chimie' => 8,
          ];
        return $this->render('base.html.twig',['prenom' => $prenom, 'nom' => $nom, 'notes'=> $notes]);
    }
}
