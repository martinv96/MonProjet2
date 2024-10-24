<?php

namespace App\Controller;

use App\Entity\Taches;
use App\Entity\TodosList;
use App\Repository\TachesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class TachesController extends AbstractController
{
    #[Route('/todolist/{id}/taches', name: 'taches.create', methods: ['POST'])]
    public function creerTache(Request $request, TodosList $todosList, TachesRepository $repository): Response
{
    $titre = $request->request->get('title');
    $isFinished = $request->request->get('isFinished') !== null;

    if (empty($titre)) {
        return $this->json(['erreur' => 'Le titre est obligatoire'], 400);
    }

    $nouvelleTache = new Taches();
    $nouvelleTache->setTitle($titre)
                  ->setIsFinished($isFinished)
                  ->setTodosList($todosList)
                  ->setCreatedAt(new \DateTime());

    $repository->save($nouvelleTache, true);

    return $this->redirectToRoute('todos_list.show', ['id' => $todosList->getId()]);
}

#[Route('/taches/{id}/delete', name: 'taches.delete', methods: ['POST','DELETE'])]
public function deleteTache(Taches $taches, TachesRepository $repository): Response
{
    $todosList = $taches->getTodosList();
    $repository->supprimer($taches, true); 

    return $this->redirectToRoute('todos_list.show', ['id' => $todosList->getId()]);
}

#[Route('/taches/{id}/update', name: 'taches.update', methods: ['POST'])]
public function updateTache($id, TachesRepository $repository, Request $req): Response
{
    // Récupérer la tâche
    $tache = $repository->find($id);
    if (!$tache) {
        throw $this->createNotFoundException("Tâche non trouvée");
    }

    // Vérifier si la case à cocher 'isFinished' est cochée
    $isFinished = $req->request->get('isFinished') !== null;

    // Mettre à jour le statut de la tâche
    $tache->setIsFinished($isFinished);

    // Sauvegarder les modifications
    $repository->save($tache, true);

    // Rediriger ou retourner une réponse appropriée
    return $this->redirectToRoute('todos_list.show', ['id' => $tache->getTodosList()->getId()]);
}


}
