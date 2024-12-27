<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $mobileNumber = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $faxNumber = null;

    /**
     * @var Collection<int, SAV>
     */
    #[ORM\OneToMany(targetEntity: SAV::class, mappedBy: 'client')]
    private Collection $sAVs;

    #[ORM\Column(length: 50)]
    private ?string $spreadsheetName = null;

    public function __construct()
    {
        $this->sAVs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getMobileNumber(): ?string
    {
        return $this->mobileNumber;
    }

    public function setMobileNumber(?string $mobileNumber): static
    {
        $this->mobileNumber = $mobileNumber;

        return $this;
    }

    public function getFaxNumber(): ?string
    {
        return $this->faxNumber;
    }

    public function setFaxNumber(?string $faxNumber): static
    {
        $this->faxNumber = $faxNumber;

        return $this;
    }

    /**
     * @return Collection<int, SAV>
     */
    public function getSAVs(): Collection
    {
        return $this->sAVs;
    }

    public function addSAV(SAV $sAV): static
    {
        if (!$this->sAVs->contains($sAV)) {
            $this->sAVs->add($sAV);
            $sAV->setClient($this);
        }

        return $this;
    }

    public function removeSAV(SAV $sAV): static
    {
        if ($this->sAVs->removeElement($sAV)) {
            // set the owning side to null (unless already changed)
            if ($sAV->getClient() === $this) {
                $sAV->setClient(null);
            }
        }

        return $this;
    }

    public function getSpreadsheetName(): ?string
    {
        return $this->spreadsheetName;
    }

    public function setSpreadsheetName(string $spreadsheetName): static
    {
        $this->spreadsheetName = $spreadsheetName;

        return $this;
    }
}
