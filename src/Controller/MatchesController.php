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


    #[Route('/matchesTest', name: 'matches_test')]
    public function index(MatchesRepository $repo, TournamentRepository $tournamentRepository, UserRepository $userRepository, EntityManagerInterface $em): Response
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

    #[Route('create/{id}', name: 'create_match')]
    public function creatingMatches($id, TournamentRepository $tournamentRepository, EntityManagerInterface $em,   UserRepository $userRepository)
    {
//      Get the tournament id from my url
//      Get players from the tournament and put them in an array sorted by desc elo
//      implement the robin round algorithm

        $players = $tournamentRepository->findIdWithUser($id);


//        dump($players[0]);
        $players = $players[0]->getPlayers();

        foreach ($players as $p) {
            $playerArr[] = $p->getId();
//            dump($p);
        }
//        dump($playerArr);
        $playerArr = [1, 2, 3, 4, 5, 6, 7, 8,
        ];
        for ($round = 1; $round < count($playerArr); $round < $round++) {
//            dump("round ". $round);
            for ($i = 0; $i < count($playerArr) / 2; $i++) {
                $t = [WinnerEnum::black,WinnerEnum::white, WinnerEnum::draw];
                $m = new Matches();
                $m->setTournament($tournamentRepository->find($id));
                $m->setWhite($userRepository->find($playerArr[$i])  );
                $m->setBlack($userRepository->find($playerArr[count($playerArr) - 1 - $i]) );
                $m->setRound($round);
                $m->setWinner($t[rand(0,count($t)-1)]);
//                $em->persist($m);

                $matches['round'] = $round;
                $matches['w'] = $playerArr[$i];
                $matches['b'] = $playerArr[count($playerArr) - 1 - $i];

//                dump($m);

            }

            $var1 = [$playerArr[0], $playerArr[count($playerArr) - 1]];
            $var2 = array_slice($playerArr, 1, count($playerArr) - 2);

            $playerArr = array_merge_recursive($var1, $var2);
            dump($playerArr);
//            dump($matches);

        }
//        $matches = array('w' => 10);


//        $em->flush();
    }

    #[Route('matches/{id}', name: 'show_matches')]
    public function showMatches($id,MatchesRepository $matchesRepository) : Response
    {
        $matches = $matchesRepository->findBy(['tournament'=>$id]);

        dump($matches);

        return $this->render('matches/index.html.twig', [
            'matches'=>$matches
        ]);
    }

}
