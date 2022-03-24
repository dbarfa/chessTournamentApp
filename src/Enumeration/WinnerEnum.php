<?php

namespace App\Enumeration;

enum WinnerEnum : string
{
    case black = 'black';
    case white = 'white';
    case draw = 'draw';
}