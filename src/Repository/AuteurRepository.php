<?php
namespace App\Repository;

use App\Entity\Auteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AuteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct($doctrine, Auteur::class);
    }

    public function sauvegarder(Auteur $auteur, bool $isSave = true): Auteur
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($auteur);

        if ($isSave) {
            $entityManager->flush();
        }

        return $auteur;
    }

    public function supprimer(Auteur $auteur): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($auteur);
        $entityManager->flush();
    }
}
