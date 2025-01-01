<?php

namespace App\Entity;

use App\Repository\SAVRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SAVRepository::class)]
class SAV
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdDate = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $representative = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $breakdown = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $repairedBy = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $repairs = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comments = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $charge = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $spreadsheetName = null;

    #[ORM\ManyToOne(inversedBy: 'sAVs')]
    private ?Client $client = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $editedDate = null;

    private bool $trackChanges = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

        if ($this->trackChanges) {
            $this->editedDate = new \DateTime();
        }

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->createdDate;
    }

    public function setCreatedDate(?\DateTimeInterface $createdDate): static
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getRepresentative(): ?string
    {
        return $this->representative;
    }

    public function setRepresentative(?string $representative): static
    {
        $this->representative = $representative;

        if ($this->trackChanges) {
            $this->editedDate = new \DateTime();
        }

        return $this;
    }

    public function getBreakdown(): ?string
    {
        return $this->breakdown;
    }

    public function setBreakdown(?string $breakdown): static
    {
        $this->breakdown = $breakdown;

        if ($this->trackChanges) {
            $this->editedDate = new \DateTime();
        }

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        if ($this->trackChanges) {
            $this->editedDate = new \DateTime();
        }

        return $this;
    }

    public function getRepairedBy(): ?string
    {
        return $this->repairedBy;
    }

    public function setRepairedBy(?string $repairedBy): static
    {
        $this->repairedBy = $repairedBy;

        if ($this->trackChanges) {
            $this->editedDate = new \DateTime();
        }

        return $this;
    }

    public function getRepairs(): ?string
    {
        return $this->repairs;
    }

    public function setRepairs(?string $repairs): static
    {
        $this->repairs = $repairs;

        if ($this->trackChanges) {
            $this->editedDate = new \DateTime();
        }

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): static
    {
        $this->comments = $comments;

        if ($this->trackChanges) {
            $this->editedDate = new \DateTime();
        }

        return $this;
    }

    public function getCharge(): ?string
    {
        return $this->charge;
    }

    public function setCharge(?string $charge): static
    {
        $this->charge = $charge;

        if ($this->trackChanges) {
            $this->editedDate = new \DateTime();
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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        if ($this->trackChanges) {
            $this->editedDate = new \DateTime();
        }

        return $this;
    }

    public function getEditedDate(): ?\DateTimeInterface
    {
        return $this->editedDate;
    }

    public function setEditedDate(?\DateTimeInterface $editedDate): static
    {
        $this->editedDate = $editedDate;

        return $this;
    }

    public function disableTracking(): void
    {
        $this->trackChanges = false;
    }

    public function enableTracking(): void
    {
        $this->trackChanges = true;
    }
}
