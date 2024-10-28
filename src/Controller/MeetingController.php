<?php

namespace App\Controller;

use App\Entity\Meeting;
use App\Form\MeetingType;
use App\Repository\MeetingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MeetingController extends AbstractController
{
    #[Route('/', name: 'meeting_index')]
    public function index(MeetingRepository $meetingRepository): Response
    {
        return $this->render('meeting/index.html.twig', [
            'meetings' => $meetingRepository->findAll(),
        ]);
    }
    #[Route('/meeting/new', name: 'meeting_new')]

    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $meeting = new Meeting();
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($meeting);
            $entityManager->flush();

            return $this->redirectToRoute('meeting_index');
        }

        return $this->render('meeting/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/meeting/{id}/edit', name: 'meeting_edit')]


    public function edit(Request $request, Meeting $meeting, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MeetingType::class, $meeting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('meeting_index');
        }

        return $this->render('meeting/edit.html.twig', [
            'form' => $form->createView(),
            'meeting' => $meeting,
        ]);
    }



    #[Route('/meeting/{id}/delete', name: 'meeting_delete')]

    public function delete(Request $request, Meeting $meeting, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $meeting->getId(), $request->request->get('_token'))) {
            $entityManager->remove($meeting);
            $entityManager->flush();
        }

        return $this->redirectToRoute('meeting_index');
    }
    #[Route('/category', name: 'category')]
    public function categories(): Response
    {
        // Vous pouvez soit récupérer les catégories à partir d'une entité, soit les définir statiquement.
        $categories = ['Travail', 'Maison', 'Loisirs', 'Santé', 'À faire'];

        return $this->render('meeting/category.html.twig', [
            'categories' => $categories,
        ]);
    }
    #[Route('/category/{categoryName}', name: 'category_tasks')]
    public function categoryTasks(string $categoryName, MeetingRepository $meetingRepository): Response
    {
        $meetings = $meetingRepository->findBy(['category' => $categoryName]); // Adaptez en fonction de votre structure

        return $this->render('meeting/category_tasks.html.twig', [
            'meetings' => $meetings,
            'categoryName' => ucfirst($categoryName), // Pour afficher la première lettre en majuscule
        ]);
    }
}
