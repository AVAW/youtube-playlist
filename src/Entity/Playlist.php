<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PlaylistRepository;
use App\Utils\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PlaylistRepository::class)
 */
class Playlist implements \Stringable
{

    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="uuid")
     * @Groups({"simple"})
     */
    private string $uuid;

    /**
     * @ORM\Column(type="string", length=1024)
     */
    private string $url;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"simple"})
     */
    private string $youtubeId;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $publishedAt;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private ?string $title;

    /**
     * @ORM\Column(type="string", length=2048, nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $channelTitle;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $videosAmount;

    public function __toString(): string
    {
        return __CLASS__ . '_' . $this->getId();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid($uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getYoutubeId(): string
    {
        return $this->youtubeId;
    }

    public function setYoutubeId(string $youtubeId): self
    {
        $this->youtubeId = $youtubeId;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getChannelTitle(): ?string
    {
        return $this->channelTitle;
    }

    public function setChannelTitle(?string $channelTitle): self
    {
        $this->channelTitle = $channelTitle;

        return $this;
    }

    public function getVideosAmount(): ?int
    {
        return $this->videosAmount;
    }

    public function setVideosAmount(?int $videosAmount): self
    {
        $this->videosAmount = $videosAmount;

        return $this;
    }

}
