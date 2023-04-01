<?php

namespace App\Enums;

enum BalanceHistoryOperationEnum : string
{
    case Increment = 'increment';
    case Decrement = 'decrement';
}
