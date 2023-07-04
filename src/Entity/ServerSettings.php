<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ServerSettingsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServerSettingsRepository::class)]
#[ApiResource]
class ServerSettings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastConnection = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getLastConnection(): ?\DateTimeInterface
    {
        return $this->lastConnection;
    }

    public function setLastConnection(?\DateTimeInterface $lastConnection): static
    {
        $this->lastConnection = $lastConnection;

        return $this;
    }
}
