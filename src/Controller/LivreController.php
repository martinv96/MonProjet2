<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivreController extends AbstractController
{
    #[Route("/livre", name: "livres.create", methods: ["POST"])]

    function creerLivre(Request $req, LivreRepository $repository)
    {

        // Récupérer les données depuis la remote
        $titre = $req->request->get("titre");

        // valider le titre
        if (!isset($titre) || $titre == "") {
            return $this->json(["erreur" => "titre obligatoire !"]);
        }

        // Créer le livre
        $nouveauLivre = new Livre();
        $nouveauLivre->setTitre($titre);

        // Enregistrer le livre dans la BDD
        $livreSauvegarder = $repository->sauvegarder($nouveauLivre, true);

        return $this->json(['id' => $livreSauvegarder->getId(), 'titre' => $livreSauvegarder->getTitre()]);
    }

    #[Route("/livre", name: "livres.tout", methods: ["GET"])]

    public function recupereTousLivres(LivreRepository $repo)
    {
        $livres = $repo->findAll();

        $livresTableau = [];
        foreach ($livres as $livre) {
            $livresTableau[] = ['id' => $livre->getId(), 'titre' => $livre->getTitre()];
        }

        return $this->json($livresTableau);
    }

    // livre?id=1
    // livre/1
    #[Route("/livre/{id}", name: "livres.id", methods: ["GET"])]

    function recupererLivre(LivreRepository $repo, $id)
    {
        // Récupérer le livre avec son ID
        $livre = $repo->find($id);
        if (!$livre) {
            // Si le livre n'existe pas on retourne un 404
            return $this->json("le livre n'existe pas", Response::HTTP_NOT_FOUND);
        }
        // retourner le livre récupérer
        return $this->json(['id' => $livre->getId(), 'titre' => $livre->getTitre()]);
    }

    #[Route("/livre/{id}", name: "livres.update", methods: ["POST"])]

    function mettreAJour($id, LivreRepository $repo, Request $req)
    {
        $livre = $repo->find($id);
        if (!$livre) {
            return $this->json("le livre n'existe pas", Response::HTTP_NOT_FOUND);
        }

        $nouveauTitre = $req->request->get("titre");

        if (!isset($nouveauTitre) || $nouveauTitre == "") {
            return $this->json('titre obligatoire', Response::HTTP_BAD_REQUEST);
        }


        $livre->setTitre($nouveauTitre);
        $repo->sauvegarder($livre, true);

        return $this->json('livre mis a jour', Response::HTTP_OK);
    }

    #[Route("/livre/{id}", name: "livres.supprimer", methods: ["DELETE"])]

    function supprimerLivre($id, LivreRepository $repo)
    {
        // récupérer le livre avec son identifiant
        $livre = $repo->find($id);

        // si le livre n'existe pas, on retourne un 404
        if (!$livre) {
            return $this->json("le livre n'existe pas", Response::HTTP_NOT_FOUND);
        }

        // supprimer le livre de la BDD
        $repo->supprimer($livre);

        // Retourne un message (quand ca marche)
        return $this->json("livre supprimer", Response::HTTP_OK);
    }
}
