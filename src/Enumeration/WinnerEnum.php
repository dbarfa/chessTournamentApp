<?php

namespace App\Enumeration;

enum WinnerEnum : string
{
    case notPlayed = 'notPlayed';
    case black = 'black';
    case white = 'white';
    case draw = 'draw';
}