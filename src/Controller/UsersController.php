<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route(':/user',name: 'printUser')]
    public function printUser(Request $request, UserRepository $repo){
        $print = $repo->findAll();


        dump($print);


        return $this->render('printUser.html.twig',[
            'print'=>$print
        ]);

    }
}
