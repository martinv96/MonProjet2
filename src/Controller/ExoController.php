<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExoController
{
    #[Route("/aleatoire", name: "aleatoire", methods: ["GET"])]

    function exo() {
        $nombre = random_int(0, 1000); 
        return new Response("<h1>Route /aleatoire</h1> <br> un nombre aleatoire : $nombre");
    }

    #[Route("/today", name: "dateDuJour", methods: ["GET"])]

    function dateDuJour() {
        $date = (new \DateTime())->format('d/m/Y H:i:s');

        $html = <<<HTML
        <h1>Route /today</h1>
        <p>Date du jour : <span id="date">$date</span></p>
        <script>
            function updateClock() {
                const now = new Date();
                const formattedDate = now.toLocaleDateString('fr-FR') + ' ' + now.toLocaleTimeString('fr-FR');
                document.getElementById('date').textContent = formattedDate;
            }
            setInterval(updateClock, 1000); // Met à jour toutes les secondes
            updateClock(); // Mise à jour immédiate lors du chargement
        </script>
HTML;
        return new Response("$html", Response::HTTP_OK);
    }


    // route dynamique : l'utilisateur peut taper son nom dans la route, la page affiche son nom.
    #[Route("/salut/{nom}", name: "bonjour", methods: ["GET"])]
    public function bonjour(string $nom): Response
    {
        return new Response("Salut $nom", Response::HTTP_OK);
    }

    
    #[Route("/calcul/{a}/{b}", name: "addition", methods: ["GET"])]
    // ajout d'une boucle if pour renvoyer une réponse dans le cas ou l'utilisateur ne tape pas un chiffre.
    function addition($a,$b) {
        if (!is_numeric($a | $b)) {
            return new Response("pas possible, taper un nombre");
        }
        $resultat = $a + $b;
        return new Response("<h1>page /addition </h1> <br>résultat de $a et $b :  $resultat");
    }
}
