<?php

namespace App\Controller;

use App\Form\NotesForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotesController extends AbstractController
{
    #[Route('/notes', name: 'notes.show', methods:['GET'])]
    function notes(Request $request): Response    
    {
        $notesForm = $this->createForm(NotesForm::class);

        $notesForm->handleRequest($request);


        return $this->render('notes.html.twig', ['notes' => $notesForm->createView()]);
    }
}

// exercice:
// 1. Créer une classe pour le formulaire: MatieresForm
// 2. Ajouter des champs: nom complet, matieres, note
// 3. Utiliser afficher le formulaire dans le controleur et la vue

class MatieresForm {
    private $nom;

    private $matieres;

    private $note;

    public function getNom() { return $this->nom; }
    public function setNom($nom) { $this->nom = $nom; return $this; }

    public function getMatieres() { return $this->matieres; }

    public function setMatieres($matieres) {$this->matieres = $matieres; return $this;}

    public function getNote() {return $this->note;}

    public function setNote($note) {$this->note->$note; return $this;}
}
