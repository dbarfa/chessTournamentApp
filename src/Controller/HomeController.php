<?php

namespace App\Controller;

use App\Entity\User;
use App\Enumeration\SexEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
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
        return $this->render('home/index.html.twig');
    }
}
