<?php

namespace App\Tests\Utils;

use App\Entity\TimestampableInterface;
use App\Utils\LastUpdateHelper;
use PHPUnit\Framework\TestCase;

class LastUpdateHelperTest extends TestCase
{

    public function testIsUpdatedInLastMinutesCreatedAt()
    {
        $nowMinus10Minutes = new \DateTime();
        $nowMinus10Minutes->sub(new \DateInterval('PT10M'));

        $simpleEntity = new SimpleEntity($nowMinus10Minutes);

        $this->assertFalse(LastUpdateHelper::isUpdatedInLastXMinutes($simpleEntity, 5));
        $this->assertTrue(LastUpdateHelper::isUpdatedInLastXMinutes($simpleEntity, 15));
    }

    public function testIsUpdatedInLastMinutesCreatedAtUpdatedAt()
    {
        $nowMinus10Minutes = new \DateTime();
        $nowMinus10Minutes->sub(new \DateInterval('PT10M'));

        $nowMinus7Minutes = new \DateTime();
        $nowMinus7Minutes->sub(new \DateInterval('PT10M'));

        $simpleEntity = new SimpleEntity($nowMinus10Minutes, $nowMinus7Minutes);

        $this->assertFalse(LastUpdateHelper::isUpdatedInLastXMinutes($simpleEntity, 5));
        $this->assertTrue(LastUpdateHelper::isUpdatedInLastXMinutes($simpleEntity, 15));
    }

}

class SimpleEntity implements TimestampableInterface
{

    private \DateTimeInterface $createdAt;
    private ?\DateTimeInterface $updatedAt;

    public function __construct(
        \DateTimeInterface $createdAt,
        ?\DateTimeInterface $updatedAt = null
    ) {
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

}
