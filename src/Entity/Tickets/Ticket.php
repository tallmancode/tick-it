<?php

namespace App\Entity\Tickets;

use App\Entity\Users\User;
use App\Repository\Tickets\TicketRepository;
use App\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 */
class Ticket
{
    use TimestampTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     * @Gedmo\Blameable(on="create")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=TicketType::class, inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ticketType;

    /**
     * @ORM\ManyToOne(targetEntity=TicketStatus::class, inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ticketStatus;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTicketType(): ?TicketType
    {
        return $this->ticketType;
    }

    public function setTicketType(?TicketType $ticketType): self
    {
        $this->ticketType = $ticketType;

        return $this;
    }

    public function getTicketStatus(): ?TicketStatus
    {
        return $this->ticketStatus;
    }

    public function setTicketStatus(?TicketStatus $ticketStatus): self
    {
        $this->ticketStatus = $ticketStatus;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
