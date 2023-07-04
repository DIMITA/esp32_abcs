<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DeviceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeviceRepository::class)]
#[ApiResource]
class Device
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 55, nullable: true)]
    private ?string $fonctionnalityId = null;

    #[ORM\Column(length: 55, nullable: true)]
    private ?string $deviceName = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastconnected = null;

    #[ORM\Column(nullable: true)]
    private ?int $deviceType = null;

    #[ORM\Column(nullable: true)]
    private ?int $deviceConnectivity = null;

    #[ORM\OneToMany(mappedBy: 'deviceId', targetEntity: UplinkMessages::class)]
    private Collection $uplinkMessages;

    #[ORM\OneToMany(mappedBy: 'deviceId', targetEntity: TimeSeries::class)]
    private Collection $timeSeries;

    public function __construct()
    {
        $this->uplinkMessages = new ArrayCollection();
        $this->timeSeries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFonctionnalityId(): ?string
    {
        return $this->fonctionnalityId;
    }

    public function setFonctionnalityId(?string $fonctionnalityId): static
    {
        $this->fonctionnalityId = $fonctionnalityId;

        return $this;
    }

    public function getDeviceName(): ?string
    {
        return $this->deviceName;
    }

    public function setDeviceName(?string $DeviceName): static
    {
        $this->deviceName = $DeviceName;

        return $this;
    }

    public function getLastconnected(): ?\DateTimeInterface
    {
        return $this->lastconnected;
    }

    public function setLastconnected(?\DateTimeInterface $lastconnected): static
    {
        $this->lastconnected = $lastconnected;

        return $this;
    }

    public function getDeviceType(): ?int
    {
        return $this->deviceType;
    }

    public function setDeviceType(?int $deviceType): static
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    public function getDeviceConnectivity(): ?int
    {
        return $this->deviceConnectivity;
    }

    public function setDeviceConnectivity(?int $deviceConnectivity): static
    {
        $this->deviceConnectivity = $deviceConnectivity;

        return $this;
    }

    /**
     * @return Collection<int, UplinkMessages>
     */
    public function getUplinkMessages(): Collection
    {
        return $this->uplinkMessages;
    }

    public function addUplinkMessage(UplinkMessages $uplinkMessage): static
    {
        if (!$this->uplinkMessages->contains($uplinkMessage)) {
            $this->uplinkMessages->add($uplinkMessage);
            $uplinkMessage->setDeviceId($this);
        }

        return $this;
    }

    public function removeUplinkMessage(UplinkMessages $uplinkMessage): static
    {
        if ($this->uplinkMessages->removeElement($uplinkMessage)) {
            // set the owning side to null (unless already changed)
            if ($uplinkMessage->getDeviceId() === $this) {
                $uplinkMessage->setDeviceId(null);
            }
        }

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
            $timeSeries->setDeviceId($this);
        }

        return $this;
    }

    public function removeTimeSeries(TimeSeries $timeSeries): static
    {
        if ($this->timeSeries->removeElement($timeSeries)) {
            // set the owning side to null (unless already changed)
            if ($timeSeries->getDeviceId() === $this) {
                $timeSeries->setDeviceId(null);
            }
        }

        return $this;
    }
}
