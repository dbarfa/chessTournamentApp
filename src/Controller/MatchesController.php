<?php

namespace App\Controller;

use App\Entity\Matches;
use App\Enumeration\WinnerEnum;
use App\Repository\MatchesRepository;
use App\Repository\TournamentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchesController extends AbstractController
{


    #[Route('/matches', name: 'app_matches')]
    public function index(MatchesRepository $repo,TournamentRepository $tournamentRepository, UserRepository $userRepository,EntityManagerInterface $em): Response
    {
        $matches = new Matches();
        $user1 = $userRepository->find(6);
        $user2 = $userRepository->find(10);

        $tournament = $tournamentRepository->find(6);
        $matches->setTournament($tournament);
        $matches->setWhite($user1);
        $matches->setBlack($user2);
        $matches->setRound(1);
        $matches->setWinner(WinnerEnum::black);
        $em->persist($matches);
        $em->flush();

        dump($matches);
        return $this->render('matches/index.html.twig', [
            'controller_name' => 'MatchesController',
        ]);
    }
}
