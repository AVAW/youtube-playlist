<?php

declare(strict_types=1);

namespace App\Utils\Timestampable;

interface TimestampableInterface
{

    public function getCreatedAt(): \DateTimeInterface;

    public function getUpdatedAt(): ?\DateTimeInterface;

}
