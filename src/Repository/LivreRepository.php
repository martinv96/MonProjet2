<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct($doctrine, Livre::class);
    }

    public function sauvegarder(Livre $nouveauLivre, bool $isSave = true): Livre
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($nouveauLivre);  // Ajout de persist

        if ($isSave) {
            $entityManager->flush();  // Exécuter la sauvegarde si demandé
        }

        return $nouveauLivre;  // Retourner l'entité sauvegardée
    }

    function supprimer(Livre $livre) 
    {
        $this->getEntityManager()->remove($livre);
        $this->getEntityManager()->flush();
    }
}
