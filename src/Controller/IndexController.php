<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PersonneType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PaginatorInterface $paginator,PersonneRepository $personneRepository, Request $request)
    {


        $lesPersonnes = $paginator->paginate(
            $personneRepository->findAll(),
            $request->query->getInt('page', 1),
            5
        );



        return $this->render('index.html.twig', [
            'lespersonnes' => $lesPersonnes,
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(EntityManagerInterface $manager, Request $request)
    {

        $form = $this->createForm(PersonneType::class);
        $user = new Personne();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $dateActuelle = new \DateTime();
            $infopersonne = $form->getData();
            $dateUser = $infopersonne->getDate();
            $interval = $dateUser->diff($dateActuelle);
            $resultat = $interval->format("%Y");
            $infopersonne->setAge($resultat);

            $manager->persist($infopersonne);
            $manager->flush();

            $this->addFlash(
                'notice',
                'Super! Un nouvel utilisateur a été ajouté !'
            );

            return $this->redirectToRoute('home');
        }


        return $this->render('ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Personne $personne, EntityManagerInterface $manager, Request $request)
    {
        $form = $this->createForm(PersonneType::class, $personne);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $dateActuelle = new \DateTime();
            $infopersonne = $form->getData();
            $dateUser = $infopersonne->getDate();
            $interval = $dateUser->diff($dateActuelle);
            $resultat = $interval->format("%Y");
            $infopersonne->setAge($resultat);

            $manager->persist($infopersonne);
            $manager->flush();

            $this->addFlash(
                'notice',
                'Super! Un nouvel utilisateur a été modifié !'
            );

            return $this->redirectToRoute('home');
        }

        return $this->render('edit.html.twig', [
            'personne' => $personne,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Personne $personne){
        //Car::class = Entity\Car
        //$car = $this->getDoctrine()->getRepository(Car::class)->find($id);
        return $this->render('show.html.twig', [
            'personne' => $personne
        ]);
    }


    /**
     * @Route("delete/{id}", name="delete")
     */
    public function delete(Personne $personne, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($personne);
        $entityManager->flush();
        $this->addFlash(
            'notice',
            'Super! Vous avez supprimé !'
        );

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/totalpersonne", name="totalpersonne")
     */
    public function totalpersonne(PersonneRepository $personneRepository)
    {
        $lesPersonnes = $personneRepository->findAll();

        return $this->render('total.html.twig', [
            'lespersonnes' => $lesPersonnes,
        ]);

    }


}