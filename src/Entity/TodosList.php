<?php

namespace App\Entity;

use App\Repository\TodosListRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: TodosListRepository::class)]
class TodosList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'todosList', targetEntity: Taches::class, cascade: ['persist', 'remove'])]
    private Collection $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Taches>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Taches $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setTodosList($this);
        }

        return $this;
    }

    public function removeTask(Taches $task): self
    {
        if ($this->tasks->removeElement($task)) {
            if ($task->getTodosList() === $this) {
                $task->setTodosList(null);
            }
        }

        return $this;
    }
}
