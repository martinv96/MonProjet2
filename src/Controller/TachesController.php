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
    $isFinished = $request->request->get('isFinished') !== null; // Checkbox checked or not

    if (empty($titre)) {
        return $this->json(['erreur' => 'Le titre est obligatoire'], 400);
    }

    $nouvelleTache = new Taches();
    $nouvelleTache->setTitle($titre)
                  ->setIsFinished($isFinished)
                  ->setTodosList($todosList)
                  ->setCreatedAt(new \DateTime()); // Ajout de la date de création

    $repository->save($nouvelleTache, true);

    // Rediriger vers la page de la liste de tâches après avoir ajouté une tâche
    return $this->redirectToRoute('todos_list.show', ['id' => $todosList->getId()]); // Modifiez le nom ici
}

#[Route('/taches/{id}', name: 'taches.delete', methods: ['POST', 'DELETE'])]
public function deleteTache(Taches $taches, TachesRepository $repository): Response
{
    $todosList = $taches->getTodosList();
    $repository->remove($taches, true); // Suppression de la tâche

    // Rediriger vers la page de la liste après la suppression de la tâche
    return $this->redirectToRoute('todos_list.index', ['id' => $todosList->getId()]);
}

}
