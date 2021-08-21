<?php

namespace App\Entity\Tickets;

use App\Entity\Customers\Customer;
use App\Entity\Users\user;
use App\Repository\Tickets\ReplyRepository;
use App\Traits\BlamableTrait;
use App\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ReplyRepository::class)
 */
class Reply
{
    use TimestampTrait, BlamableTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Ticket::class, inversedBy="replies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ticket;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="replies")
     * @ORM\JoinColumn(nullable=false)
     * @Gedmo\Blameable(on="create")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="replies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(?Ticket $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}
