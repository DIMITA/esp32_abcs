<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TimeSeriesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\Esp32PostController;

#[ORM\Entity(repositoryClass: TimeSeriesRepository::class)]
#[ApiResource(operations: [
    new Get(),
    new GetCollection(paginationEnabled: true),
    new Post(
        name: 'publication',
        uriTemplate: '/times_series/',
        controller: Esp32PostController::class
    )
])]
#[ApiFilter(DateFilter::class, properties: ['dateTimeOffset'])]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'exact'])]
class TimeSeries
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateTimeOffset = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $value = null;

    #[ORM\ManyToOne(inversedBy: 'timeSeries')]
    private ?Device $deviceId = null;

    #[ORM\ManyToOne(inversedBy: 'timeSeries')]
    private ?UplinkMessages $UplinkMessageId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDateTimeOffset(): ?\DateTimeInterface
    {
        return $this->dateTimeOffset;
    }

    public function setDateTimeOffset(?\DateTimeInterface $dateTimeOffset): static
    {
        $this->dateTimeOffset = $dateTimeOffset;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getDeviceId(): ?Device
    {
        return $this->deviceId;
    }

    public function setDeviceId(?Device $deviceId): static
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    public function getUplinkMessageId(): ?UplinkMessages
    {
        return $this->UplinkMessageId;
    }

    public function setUplinkMessageId(?UplinkMessages $UplinkMessageId): static
    {
        $this->UplinkMessageId = $UplinkMessageId;

        return $this;
    }
}
