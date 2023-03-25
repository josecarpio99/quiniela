<?php

namespace App\Enums;

enum GameResultPredictionPointsEnum : int
{
    case EXACT_SCOREBOARD = 4;
    case CORRECT_RESULT   = 2;
    case FAILED_RESULT    = -1;
}
