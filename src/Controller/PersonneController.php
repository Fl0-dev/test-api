<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    /**
     * @Route("/personne/", name="personne_liste", methods={"GET"})
     */
    public function index(PersonneRepository $personneRepository): Response
    {
        // $tab['message'] = 'hello world';
        return $this->json($personneRepository->findAll());
    }

    /**
     * @Route("/personne/{id}/ajouter", name="personne_ajouter", methods={"POST"})
     */
    public function ajouter(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $p = json_decode($request->getContent());
        $personne=new Personne();
        $personne->setPrenom($p->prenom);
        $personne->setNom($p->nom);
        $entityManager->persist($personne);
        $entityManager->flush();
        return $this->json($personne);
    }

    /**
     * @Route("/personne/{id}/modifier", name="personne_modifier", methods={"PUT"})
     */
    public function modifier(
        Personne $personne,
        Request $request,
        EntityManagerInterface $entityManager

    ): Response
    {
        $p = json_decode($request->getContent());
        $personne->setPrenom($p->prenom);
        $personne->setNom($p->nom);
        $entityManager->flush();
        return $this->json($personne);
    }

    /**
     * @Route("/personne/{id}/enlever", name="personne_enlever", methods={"DELETE"})
     */
    public function enlever(
        Personne $personne,
        EntityManagerInterface $entityManager
    ): Response
    {
        $entityManager->remove($personne);
        $entityManager->flush();
        return $this->json($personne);
    }
}
