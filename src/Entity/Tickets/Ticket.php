<?php

namespace App\Entity\Tickets;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use App\Entity\Customers\Customer;
use App\Entity\Users\User;
use App\Repository\Tickets\TicketRepository;
use App\Traits\BlamableTrait;
use App\Traits\TimestampTrait;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;


/**
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"ticket:read"}},
 *     denormalizationContext={"groups"={"ticket:write"}, "disable_type_enforcement"=true},
 * )
 * @ApiFilter(OrderFilter::class, properties={"createdAt", "customer.name", "title", "customer.surname", "ticketStatus.name"})
 */
class Ticket
{
    use TimestampTrait, BlamableTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"ticket:read", "ticket:write"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     * @Gedmo\Blameable(on="create")
     * @Groups({"ticket:read"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=TicketType::class, inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"ticket:read", "ticket:write"})
     * @Assert\Valid
     */
    private $ticketType;

    /**
     * @ORM\ManyToOne(targetEntity=TicketStatus::class, inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"ticket:read", "ticket:write"})
     */
    private $ticketStatus;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"ticket:read", "ticket:write"})
     * @Assert\NotBlank(message="Please tell us how we can help")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"ticket:read", "ticket:write"})
     * @Assert\NotBlank(message="Please enter a title for your ticket")
     * @Assert\Length(
     *     max= 255,
     *     maxMessage="Your title can't be more than {{ limit }} characters"
     * )
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=Reply::class, mappedBy="ticket")
     */
    private $replies;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="tickets" ,cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"ticket:read", "ticket:write"})
     */
    private $customer;

    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Groups({"ticket:read"})
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=8)
     * @Groups({"ticket:read", "ticket:write"})
     */
    private $latitude;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=8)
     * @Groups({"ticket:read", "ticket:write"})
     */
    private $longitude;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    public function __construct()
    {
        $this->replies = new ArrayCollection();
    }

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
            $reply->setTicket($this);
        }

        return $this;
    }

    public function removeReply(Reply $reply): self
    {
        if ($this->replies->removeElement($reply)) {
            // set the owning side to null (unless already changed)
            if ($reply->getTicket() === $this) {
                $reply->setTicket(null);
            }
        }

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

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }
}
