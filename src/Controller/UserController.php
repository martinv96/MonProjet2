<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionForm;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route("/inscription", name: "inscription", methods: ["GET", "POST"])]
    public function inscription(Request $request, UserPasswordHasherInterface $password): Response
    {
        // si connecté, redirige vers le profil 
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('profil');
        }
        $user = new User();
        
        // Création du formulaire à partir de la classe `InscriptionForm`
        $inscriptionForm = $this->createForm(InscriptionForm::class, $user);

        // Gestion de la soumission du formulaire
        $inscriptionForm->handleRequest($request);

        if ($inscriptionForm->isSubmitted() && $inscriptionForm->isValid()) {

            $plainPassword = $user->getPassword();
            $hashedpassword = $password->hashPassword($user, $plainPassword);
            $user->setPassword($hashedpassword);

            // Sauvegarder l'utilisateur en base de données
            $this->userRepository->save($user, true);

            // Redirection vers une page de succès après l'inscription
            return $this->redirectToRoute('connexion');  // Remplacez par votre route de succès
        }

        // Retourne la vue avec le formulaire
        return $this->render('inscription.html.twig', [
            'formulaire' => $inscriptionForm->createView()
        ]);
    }

    #[Route("/connexion", name: "connexion", methods: ["GET", "POST"])]
    function connexion () {

        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('profil');
        }
        $connexionForm = $this->createForm(InscriptionForm::class);
        return $this->render('connexion.html.twig', ['connexionForm' => $connexionForm->createView()]);
    }

    #[Route("/profil", name: "profil")]
    function profil() {
        
        return $this->render('profil.html.twig');
    }

    #[Route("/admin", name: "admin")]
    function admin() {
        
        if($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('connexion');
        }
        if($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('profil');
        }
        return $this->render('admin.html.twig');
    }

    #[Route("/logout", name: "logout")]
    function logout() {}
}
