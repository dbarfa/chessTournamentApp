<?php

namespace App\Twig;


use App\Enumeration\AgeCategoryEnum;
use App\Enumeration\SexEnum;
use App\Repository\TournamentRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{


    private $security;
    private $tourRepo;

    public function __construct(Security $security,TournamentRepository $tourRepo)
    {
        $this->security = $security;
        $this->tourRepo = $tourRepo;
    }


    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('func1', [$this, 'doSomething']),
        ];
    }

    public function doSomething($tournament)
    {

        $test = $tournament->getPlayers();
        $test2 = [];
        foreach ($test as $t){
            $test2[] = $t->getId();
        }
        $user = $this->security->getUser();

        if ($user!=null){
            $userId = $user->getId();
        }

        if (($user != null) and !in_array($userId,$test2)  ) {

            $userElo = $user->getElo();


            $userSex = $user->getSex()->value;

            $userBirth = $user->getBirthDate();
            $dateNow = new \DateTime();
            $ageDate = $dateNow->diff($userBirth);
            $ageInt = intval($ageDate->format('%y'));

            $ageCat = AgeCategoryEnum::Open->value;


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

            $elo = ($tournament->getEloMin() < $requirements['elo'] &&
                $tournament->getEloMax() > $requirements['elo']);

            $sex = ($tournament->getSex()->value == $requirements['sex'] || $tournament->getSex()->value == SexEnum::Genderless->value);

            $age = ($tournament->getAgeCat()->value == $requirements['age'] || $tournament->getAgeCat()->value == AgeCategoryEnum::Open->value  );

            if ($elo && $sex && $age) {
                return true;

            } else {

                return false;

            }

        }
//        throw new NotFoundHttpException();
    }
}
