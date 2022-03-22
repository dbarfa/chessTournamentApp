<?php

namespace App\Controller;

use App\Entity\Tournament;
use App\Enumeration\AgeCategoryEnum;
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
            $request->query->get('limit') ?: 4,
            $request->query->get('keyword')
        ];

        $user = $this->getUser();
        dump($user);


        if (($user != null)) {
            // user is connected => we do the findBySearchRequirements
//         ////////////Elo
            $userElo = $user->getElo();
            dump($userElo);
//          ////////////Sex

            $userSex = $user->getSex()->value;
            dump($userSex);
//          ////////////Age
            $userBirth = $user->getBirthDate();
            $dateNow = new \DateTime();
            $ageDate = $dateNow->diff($userBirth);
            $ageInt = intval($ageDate->format('%y'));
            dump($ageInt);

            $ageCat = AgeCategoryEnum::Open->value;
//            if ($ageInt < 18) {
//                $ageCat = AgeCategoryEnum::Junior->value;
//            } elseif ($ageInt <= 64) {
//                $ageCat = AgeCategoryEnum::Senior->value;
//            } elseif ($ageInt > 64) {
//                $ageCat = AgeCategoryEnum::Veteran->value;
//            }
            dump($ageCat);


            switch ($ageInt) {
                case $ageInt < 18 :
                    $ageCat = AgeCategoryEnum::Junior->value;
                    break;
                case $ageInt <= 64 :
                    $ageCat = AgeCategoryEnum::Senior->value;
                    break;
                case $ageInt > 64 :
                    $ageCat = AgeCategoryEnum::Veteran->value;
                    break;
            }


            $requirements = [
                'elo' => $userElo,
                'sex' => $userSex,
                'age' => $ageCat,
            ];
            dump($requirements);
            dump($requirements['elo']);


            $print = $repoTour->findBySearchRequirements($search, $requirements);
//            $print = $repoTour->findAll();


            dump('true');


        } else {
            dump('this is false');
            $print = $repoTour->findBySearch($search);
        }

//        $print = $repo->findByReq($user);
//        dump($print);


        $total = $repoTour->countBySearch($request->query->get('keyword'));


        return $this->render('tournament/index.html.twig', [
            'print' => $print,
            'total' => $total,

        ]);
    }

    #[Route('add_tournament', name: 'add_tournament')]
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
}
