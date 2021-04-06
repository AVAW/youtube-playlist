<?php

declare(strict_types=1);

namespace App\Utils;

use App\Entity\TimestampableInterface;

class LastUpdateHelper
{

    public static function isUpdatedInLastXMinutes(TimestampableInterface $object, int $minutes): bool
    {
        $interval = new \DateInterval('PT' . $minutes . 'M');
        $now = new \DateTime();
        $now->sub($interval);

        if ($object->getUpdatedAt() instanceof \DateTimeInterface) {

            return $object->getUpdatedAt()->getTimestamp() >= $now->getTimestamp();
        }

        return false;
    }

}
