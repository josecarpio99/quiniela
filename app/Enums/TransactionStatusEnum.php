<?php

namespace App\Enums;

enum TransactionStatusEnum : string
{
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Pending  = 'pending';

    public static function all() : array
    {
        return [
            self::Approved->value => self::Approved->value,
            self::Rejected->value => self::Rejected->value,
            self::Pending->value => self::Pending->value
        ];
    }

    public static function allExceptFor(string $status) : array
    {
        $allStatus = self::all();

        if (isset($allStatus[$status])) {
            unset($allStatus[$status]);
        }

        return $allStatus;
    }
}
