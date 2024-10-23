<?php

namespace App\Controller;

use App\Entity\TodosList;
use App\Repository\TodosListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class TodosListController extends AbstractController
{
    #[Route('/todos-list', name: 'todos_list.create', methods: ['POST'])]
    public function creerListe(Request $request, TodosListRepository $repository): Response
    {
        $title = $request->request->get('title');

        if (empty($title)) {
            return $this->json(['erreur' => 'Le titre est obligatoire'], 400);
        }

        $nouvelleListe = new TodosList();
        $nouvelleListe->setTitle($title);

        $repository->save($nouvelleListe, true);

        return $this->redirectToRoute('todos_list.index');
    }

    #[Route('/todos-list', name: 'todos_list.index', methods: ['GET'])]
    public function getAllTodosLists(TodosListRepository $todosListRepository): Response
    {
        $lists = $todosListRepository->findAll();

        return $this->render('index.html.twig', [
            'lists' => $lists,
        ]);
    }

    #[Route('/todos-list/{id}', name: 'todos_list.show', methods: ['GET'])]
    public function getTodosListById(TodosList $todosList): Response
    {
        return $this->render('show.html.twig', [
            'todosList' => $todosList,
        ]);
    }

    #[Route('/todos-list/{id}', name: 'todos_list.update', methods: ['POST'])]
    public function updateTodosList(Request $request, TodosList $todosList, TodosListRepository $repository): Response
    {
        $title = $request->request->get('title');

        if ($title) {
            $todosList->setTitle($title);
            $repository->save($todosList, true);
        }

        return $this->redirectToRoute('todos_list.show', ['id' => $todosList->getId()]);
    }

    #[Route('/todos-list/{id}/delete', name: 'todos_list.delete', methods: ['POST'])]
    public function deleteTodosList(TodosList $todosList, TodosListRepository $repository): Response
    {
        $repository->remove($todosList, true); 
        return $this->redirectToRoute('todos_list.index');
    }
}
