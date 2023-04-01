<?php

namespace App\Enums;

enum TicketStatusEnum : string
{
    case Winner = 'winner';
    case Loser = 'loser';
    case Pending  = 'pending';
}
