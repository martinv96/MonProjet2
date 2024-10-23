<?php

namespace App\Entity;

use App\Repository\TachesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TachesRepository::class)]
class Taches
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: "boolean")]
    private bool $isFinished = false;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    // Relation avec l'entité TodosList (liste des tâches)
    #[ORM\ManyToOne(targetEntity: TodosList::class, inversedBy: 'tasks')]
    #[ORM\JoinColumn(nullable: false, name: 'taches_id', referencedColumnName: 'id')]
    private ?TodosList $todosList = null;

    public function __construct()
    {
        // Initialisation de la date de création lors de la création de l'objet
        $this->createdAt = new \DateTime();  // Définit la date actuelle
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

    public function isFinished(): bool
    {
        return $this->isFinished;
    }

    public function setIsFinished(bool $isFinished): self
    {
        $this->isFinished = $isFinished;

        return $this;
    }

    public function getTodosList(): ?TodosList
    {
        return $this->todosList;
    }

    public function setTodosList(?TodosList $todosList): self
    {
        $this->todosList = $todosList;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
