<?php

declare(strict_types=1);

namespace App\Utils\Timestampable;

class TimestampableHelper
{

    public static function isUpdatedInLastXMinutes(TimestampableInterface $object, int $minutes): bool
    {
        $interval = new \DateInterval('PT' . $minutes . 'M');
        $now = new \DateTime();
        $now->sub($interval);

        if ($object->getUpdatedAt() === $object->getCreatedAt()) {
            return false;
        }

        if ($object->getUpdatedAt() instanceof \DateTimeInterface) {
            return $object->getUpdatedAt() >= $now;
        }

        return $object->getCreatedAt() >= $now;
    }

}
