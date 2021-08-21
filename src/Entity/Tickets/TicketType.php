<?php

namespace App\Entity\Tickets;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\Tickets\TicketTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TicketTypeRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"ticketType:read"}},
 *     itemOperations={"get"},
 *     attributes={"pagination_enabled"=false}
 * )
 *
 */
class TicketType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"ticketType:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"ticketType:read", "ticket:read"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Ticket::class, mappedBy="ticketType")
     */
    private $tickets;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setTicketType($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getTicketType() === $this) {
                $ticket->setTicketType(null);
            }
        }

        return $this;
    }
}
