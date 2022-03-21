<?php

namespace App\Controller;

use App\Repository\TournamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TournamentController extends AbstractController
{
    #[Route('/tournament', name: 'app_tournament')]
    public function index(TournamentRepository $repo): Response
    {
        $print = $repo->findAll();


        dump($print);


        return $this->render('tournament/index.html.twig',[
            'print'=>$print
        ]);
    }
}
