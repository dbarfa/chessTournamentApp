<?php

namespace App\Controller;

use App\Entity\Tournament;
use App\Form\AddTournamentType;
use App\Repository\TournamentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TournamentController extends AbstractController
{
    #[Route('/tournament', name: 'tournament')]
    public function index(TournamentRepository $repo,Request $request): Response
    {
        $print = $repo->findBySearch(
            intval($request->query->get('offset')),
            intval($request->query->get('limit')) ?: 4,
            $request->query->get('keyword'));


        dump($print);


        $total = $repo->countBySearch($request->query->get('keyword'));


        return $this->render('tournament/index.html.twig',[
            'print'=>$print,
            'total' => $total,

        ]);
    }
    #[Route('add_tournament',name: 'add_tournament')]
    public function addTournament(Request $request, EntityManagerInterface $em, TournamentRepository $repo)
    {
        $tournament = new Tournament();
        dump($tournament);
        $form = $this->createForm(AddTournamentType::class, $tournament);
        $form->handleRequest($request);
        dump($tournament);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($tournament);
            $em->flush();


        }
            return $this->render('tournament/add.html.twig',
        [
            'form'=>$form->createView()
        ]);
    }
}
