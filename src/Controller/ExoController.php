<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExoController extends AbstractController
{
    #[Route("/aleatoire", name: "aleatoire", methods: ["GET"])]

    function exo()
    {
        $nombre = random_int(0, 1000);
        return new Response("<h1>Route /aleatoire</h1> <br> un nombre aleatoire : $nombre");
    }

    #[Route("/today", name: "dateDuJour", methods: ["GET"])]

    function dateDuJour()
    {
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

    // dans une fonction/méthode, on peut déclarer une variable dans les parametres directement en placant request devant la variable.
    // ex : function test(Request $a) {}

    #[Route("/calcul/{a}/{b}", name: "addition", methods: ["GET"])]
    // ajout d'une boucle if pour renvoyer une réponse dans le cas ou l'utilisateur ne tape pas un chiffre.
    function addition($a, $b)
    {
        if (!is_numeric($a | $b)) {
            return new Response("pas possible, taper un nombre");
        }
        $resultat = $a + $b;
        return new Response("<h1>page /addition </h1> <br>résultat de $a et $b :  $resultat");
    }

    #[Route("/inscription", name: "inscription", methods: ["POST"])]

    function insription(Request $requete)
    {
        // var_dump($requete->request);
        return new Response(
            $requete->request->get('email'),
            Response::HTTP_OK
        );
    }

    // Créer une Route /connexion avec la méthode POST
    // Injecter l'objet requête dans l'action.
    // Récupérer le nom, prénom, email et mot de passe du corps de la requête
    // Retourner une réponse de succès.
    // Tester la route avec Postman ou Thunder

    // bonus
    // tester si les données sont correctes, et retourner un message d'erreur si pas correcte
    // tester l'appli avec un regex
    // le nom et le prenom ne doivent pas etre vides
    // le mot de passe doit etre supérieur à 6 caractères

    #[Route("/connexion", name: "connexion", methods: ["POST"])]

    function connexion(Request $request)
    {
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        if (empty($nom) || empty($prenom)) {
            return new Response("Le nom et le prénom ne doivent pas être vides.", Response::HTTP_BAD_REQUEST);
        }

        if (!preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ\s-]+$/', $nom) || !preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ\s-]+$/', $prenom)) {
            return new Response("Le nom et le prénom doivent contenir uniquement des lettres.", Response::HTTP_BAD_REQUEST);
        }

        if (strlen($password) <= 6) {
            return new Response("Le mot de passe doit contenir plus de 6 caractères.", Response::HTTP_BAD_REQUEST);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new Response("Adresse email invalide.", Response::HTTP_BAD_REQUEST);
        }

        // Si toutes les validations passent, retourner une réponse de succès
        return new Response("Connexion réussie pour $prenom $nom", Response::HTTP_OK);
    }

    #[Route("/profile", name: "profile", methods: ["GET"])]

    function profile(Request $req)
    {
        // dans un cas concret on récupere les données de l'utilisateur depuis le DB (avec du json)
        $id = $req->request->get("id");
        return $this->json([
            "email" => "martin@vallee",
            "prenom" => "martin",
            "identifiant" =>$id
        ]);
    }
}
