<?php

namespace App\Controller;

use App\Entity\Tournament;
use App\Form\AddTournamentType;
use App\Repository\TournamentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TournamentController extends AbstractController
{
    #[Route('/tournament', name: 'tournament')]
    public function index(TournamentRepository $repoTour, Request $request, UserRepository $repoUser): Response
    {

        $search = [
            $request->query->get('offset'),
            $request->query->get('limit') ?: 10,
            $request->query->get('keyword')
        ];

        $print = $repoTour->findAllWithUserAndSearch($search);

        $total = $repoTour->countBySearch($request->query->get('keyword'));
        return $this->render('tournament/index.html.twig', [
            'print' => $print,
            'total' => $total,

        ]);
    }

    #[Route('tournament/add', name: 'add_tournament')]
    public function addTournament(Request $request, EntityManagerInterface $em, TournamentRepository $repo)
    {
        $tournament = new Tournament();
        dump($tournament);
        $form = $this->createForm(AddTournamentType::class, $tournament);
        $form->handleRequest($request);
        dump($tournament);
        if ($form->isSubmitted() && $form->isValid()) {

            $tournament->setDeleted(false);
            $em->persist($tournament);
            $em->flush();
        }
        return $this->render('tournament/add.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    #[Route('tournament/join/{id}', name: 'join_tournament')]
    public function joinTournament($id, TournamentRepository $repo,EntityManagerInterface $entityManager)
    {
        $tour = $repo->find($id);
        $user = $this->getUser();
        $user->addTournament($tour);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('tournament');
    }

    #[Route('tournament/show/{id}', name: 'show_tournament')]
    public function showPlayersTournament($id,TournamentRepository $repoTour): Response
    {

        $print = $repoTour->findIdWithUser($id);
        dump($print);

        return $this->render('tournament/show.html.twig',[
            'print'=>$print,
        ]);

    }
}
