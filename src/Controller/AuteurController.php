<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Livre;
use App\Repository\AuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Response;

class AuteurController extends AbstractController
{
    #[Route("/auteurs", name: "auteur.create", methods: ["POST"])]
    public function creerAuteur(Request $req, AuteurRepository $repository): JsonResponse
    {
        // Récuprérer les données depuis la requete
        $nom = $req->request->get("nom");
        $prenom = $req->request->get("prenom");
        $date = $req->request->get("date");

        // Valider le nom, prénom et date
        if (empty($nom) || empty($prenom) || empty($date)) {
            return $this->json(["erreur" => "Tous les champs sont obligatoires !"], 400);
        }

        // Créer l'auteur
        $nouveauAuteur = new Auteur();
        $nouveauAuteur->setNom($nom)
            ->setPrenom($prenom)
            ->setDate(new DateTimeImmutable($date));

        $auteurSauvegarde = $repository->sauvegarder($nouveauAuteur, true);

        return $this->json([
            'id' => $auteurSauvegarde->getId(),
            'nom' => $auteurSauvegarde->getNom(),
            'prenom' => $auteurSauvegarde->getPrenom()
        ]);
    }

    #[Route("/auteurs", name: "auteur.index", methods: ["GET"])]
    public function getAllAuteurs(AuteurRepository $repository): JsonResponse
    {
        $auteurs = $repository->findAll();

        $data = array_map(fn($auteur) => [
            'id' => $auteur->getId(),
            'nom' => $auteur->getNom(),
            'prenom' => $auteur->getPrenom(),
            'date' => $auteur->getDate()->format('Y-m-d')
        ], $auteurs);

        return $this->json($data);
    }

    #[Route("/auteurs/{id}", name: "auteur.show", methods: ["GET"])]
    public function getAuteurById(Auteur $auteur): JsonResponse
    {
        return $this->json([
            'id' => $auteur->getId(),
            'nom' => $auteur->getNom(),
            'prenom' => $auteur->getPrenom(),
            'date' => $auteur->getDate()->format('Y-m-d')
        ]);
    }

    #[Route("/auteurs/nom/{nom}", name: "auteur.by_name", methods: ["GET"])]
    public function getAuteurByNom(string $nom, AuteurRepository $repository): JsonResponse
    {
        $auteur = $repository->findOneBy(['nom' => $nom]);

        if (!$auteur) {
            return $this->json(['erreur' => 'Auteur non trouvé'], 404);
        }

        return $this->json([
            'id' => $auteur->getId(),
            'nom' => $auteur->getNom(),
            'prenom' => $auteur->getPrenom(),
            'date' => $auteur->getDate()->format('Y-m-d')
        ]);
    }

    #[Route("/auteurs/{id}", name: "auteur.update", methods: ["POST"])]
    public function updateAuteur(Request $req, Auteur $auteur, AuteurRepository $repository): JsonResponse
    {
        $nom = $req->request->get("nom");
        $prenom = $req->request->get("prenom");
        $date = $req->request->get("date");

        if ($nom) $auteur->setNom($nom);
        if ($prenom) $auteur->setPrenom($prenom);
        if ($date) $auteur->setDate(new DateTimeImmutable($date));

        $repository->sauvegarder($auteur, true);

        return $this->json(['message' => 'Auteur mis à jour avec succès']);
    }

    #[Route("/auteurs/{id}", name: "auteur.delete", methods: ["DELETE"])]
    public function deleteAuteur(Auteur $auteur, AuteurRepository $repository): JsonResponse
    {
        $repository->supprimer($auteur);

        return $this->json(['message' => 'Auteur supprimé avec succès']);
    }

    #[Route("/auteurs/livre/{auteur_id}", name: "auteur.livre", methods: ["POST"])]

    function addLivre(AuteurRepository $auteurRepo, Request $req, $auteur_id)
    {
        $auteur = $auteurRepo->find($auteur_id);
        if (!$auteur) {
            return $this->json("Auteur non trouvé", Response::HTTP_NOT_FOUND);
        }
        $titre = $req->request->get("titre");
        if (!isset($titre) || empty($titre)) {
            return $this->json('titre obligatoire', Response::HTTP_NOT_FOUND);
        }
        $livre = new Livre();
        $livre->setTitre($titre);

        $auteur->addLivre($livre);

        $auteurRepo->sauvegarder($auteur, true);

        return $this->json(["titre" => $livre->getTitre()]);
    }
}
