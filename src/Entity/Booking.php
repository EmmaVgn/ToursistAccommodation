<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    use Trait\CreatedAtTrait;
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $checkIn = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $checkOut = null;

    #[ORM\Column]
    private ?int $occupants = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $traveler = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Add $adds = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Review $review = null;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'booking')]
    private Collection $reviews;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getCheckIn(): ?\DateTimeInterface
    {
        return $this->checkIn;
    }

    public function setCheckIn(\DateTimeInterface $checkIn): static
    {
        $this->checkIn = $checkIn;

        return $this;
    }

    public function getCheckOut(): ?\DateTimeInterface
    {
        return $this->checkOut;
    }

    public function setCheckOut(\DateTimeInterface $checkOut): static
    {
        $this->checkOut = $checkOut;

        return $this;
    }

    public function getOccupants(): ?int
    {
        return $this->occupants;
    }

    public function setOccupants(int $occupants): static
    {
        $this->occupants = $occupants;

        return $this;
    }

    public function getTraveler(): ?User
    {
        return $this->traveler;
    }

    public function setTraveler(?User $traveler): static
    {
        $this->traveler = $traveler;

        return $this;
    }

    public function getAdds(): ?Add
    {
        return $this->adds;
    }

    public function setAdds(?Add $adds): static
    {
        $this->adds = $adds;

        return $this;
    }

    public function getReview(): ?Review
    {
        return $this->review;
    }

    public function setReview(Review $review): static
    {
        $this->review = $review;

        return $this;
    }

    // Convert checkin date to string
    public function getCheckInString(): string
    {
        return $this->getCheckIn()->format('d/m/Y');
    }

    // Convert checkout date to string
    public function getCheckOutString(): string
    {
        return $this->getCheckOut()->format('d/m/Y');
    }

    // Get the number of days between checkin and checkout
    public function getDays(): int
    {
        $diff = $this->getCheckIn()->diff($this->getCheckOut());
        return $diff->days;
    }
}
