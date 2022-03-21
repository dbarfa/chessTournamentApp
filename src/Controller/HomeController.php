<?php

namespace App\Controller;

use App\Entity\Tournament;
use App\Entity\User;
use App\Enumeration\AgeCategoryEnum;
use App\Enumeration\SexEnum;
use App\Enumeration\TournTypeEnum;
use App\Repository\TournamentRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
//    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('test',name: 'test')]
    public function testDb()
    {
        $test = new User();

        $test->setUsername('Hello');
        $test->setFirstName('hello');
        $test->setLastName('helloo');
        $test->setBirthDate('23-01-2020');
        $test->setElo(155);
        $test->setSex(SexEnum::Male->value);
        $test->setPassword('test');

        dump($test);

        dump(gettype($test->getSex()));
        return $this->render('home/index.html.twig');
    }

    #[Route('testTour',name: 'TestTour')]
    public function testTour(){
        $test = new Tournament();

        $test->setName('test');
        $test->setCity('test');
        $test->setDate('23-01-2020');
        $test->setRated(true);
        $test->setAgeCat(AgeCategoryEnum::Junior->value);
        $test->setSex(SexEnum::Male->value);
        $test->setType(TournTypeEnum::Swiss->value);


        dump($test);
        return $this->render('home/index.html.twig');
    }

    #[Route('/printUser',name: 'printUser')]
    public function printUser(Request $request, UserRepository $repo){
        $print = $repo->findAll();


        dump($print);


        return $this->render('printUser.html.twig',[
            'print'=>$print
        ]);

        }

}
