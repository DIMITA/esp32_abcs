<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UplinkMessagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UplinkMessagesRepository::class)]
#[ApiResource]
class UplinkMessages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $receivedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $rawPayload = null;

    #[ORM\Column(nullable: true)]
    private ?int $connectionConfig = null;

    #[ORM\Column(nullable: true)]
    private ?int $connectionFreq = null;

    #[ORM\ManyToOne(inversedBy: 'uplinkMessages')]
    private ?Device $deviceId = null;

    #[ORM\OneToMany(mappedBy: 'UplinkMessageId', targetEntity: TimeSeries::class)]
    private Collection $timeSeries;

    public function __construct()
    {
        $this->timeSeries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReceivedAt(): ?\DateTimeInterface
    {
        return $this->receivedAt;
    }

    public function setReceivedAt(?\DateTimeInterface $receivedAt): static
    {
        $this->receivedAt = $receivedAt;

        return $this;
    }

    public function getRawPayload(): ?string
    {
        return $this->rawPayload;
    }

    public function setRawPayload(?string $rawPayload): static
    {
        $this->rawPayload = $rawPayload;

        return $this;
    }

    public function getConnectionConfig(): ?int
    {
        return $this->connectionConfig;
    }

    public function setConnectionConfig(?int $connectionConfig): static
    {
        $this->connectionConfig = $connectionConfig;

        return $this;
    }

    public function getConnectionFreq(): ?int
    {
        return $this->connectionFreq;
    }

    public function setConnectionFreq(?int $connectionFreq): static
    {
        $this->connectionFreq = $connectionFreq;

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

    /**
     * @return Collection<int, TimeSeries>
     */
    public function getTimeSeries(): Collection
    {
        return $this->timeSeries;
    }

    public function addTimeSeries(TimeSeries $timeSeries): static
    {
        if (!$this->timeSeries->contains($timeSeries)) {
            $this->timeSeries->add($timeSeries);
            $timeSeries->setUplinkMessageId($this);
        }

        return $this;
    }

    public function removeTimeSeries(TimeSeries $timeSeries): static
    {
        if ($this->timeSeries->removeElement($timeSeries)) {
            // set the owning side to null (unless already changed)
            if ($timeSeries->getUplinkMessageId() === $this) {
                $timeSeries->setUplinkMessageId(null);
            }
        }

        return $this;
    }
}
