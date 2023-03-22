<?php

namespace App\Enums;

enum TransactionStatusEnum : string
{
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Pending  = 'pending';
}
