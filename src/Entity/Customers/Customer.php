<?php

namespace App\Entity\Customers;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Tickets\Reply;
use App\Entity\Tickets\Ticket;
use App\Repository\Customers\CustomerRepository;
use App\Traits\BlamableTrait;
use App\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 * @ApiResource ()
 */
class Customer
{
    use TimestampTrait, BlamableTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"ticket:read", "ticket:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"ticket:read", "ticket:write"})
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"ticket:read", "ticket:write"})
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=Reply::class, mappedBy="customer")
     */
    private $replies;

    /**
     * @ORM\OneToMany(targetEntity=Ticket::class, mappedBy="customer")
     */
    private $tickets;

    public function __construct()
    {
        $this->replies = new ArrayCollection();
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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Reply[]
     */
    public function getReplies(): Collection
    {
        return $this->replies;
    }

    public function addReply(Reply $reply): self
    {
        if (!$this->replies->contains($reply)) {
            $this->replies[] = $reply;
            $reply->setCustomer($this);
        }

        return $this;
    }

    public function removeReply(Reply $reply): self
    {
        if ($this->replies->removeElement($reply)) {
            // set the owning side to null (unless already changed)
            if ($reply->getCustomer() === $this) {
                $reply->setCustomer(null);
            }
        }

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
            $ticket->setCustomer($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getCustomer() === $this) {
                $ticket->setCustomer(null);
            }
        }

        return $this;
    }
}
