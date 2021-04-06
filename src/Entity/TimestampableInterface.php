<?php

namespace App\Entity;

interface TimestampableInterface
{

    public function getCreatedAt(): \DateTimeInterface;

    public function getUpdatedAt(): ?\DateTimeInterface;

}
