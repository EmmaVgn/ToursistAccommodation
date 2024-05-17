<?php

namespace App\Entity;

use DateTimeImmutable;
use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Booking
{
    use Trait\CreatedAtTrait;

    public const STATUS_PENDING = 'PENDING';
    public const STATUS_PAID = 'PAID';
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column]
    private ?int $occupants = null;

    #[ORM\Column]
    #[Assert\GreaterThanOrEqual('today', message: 'La date d\'arrivée doit être supérieure ou égale à la date d\'aujourd\'hui !')]
    private ?\DateTimeImmutable $checkIn = null;

    #[ORM\Column]
    #[Assert\GreaterThan(propertyPath: "checkOut", message: "La date de départ doit être plus éloignée que la date d'arrivée !")]
    private ?\DateTimeImmutable $checkOut = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\Column(length: 255)]
    private ?string $status = 'PENDING';

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

    #[ORM\PrePersist]
    public function prePersist()
    {
        if (empty($this->createdAt)) {
            $this->createdAt = new DateTimeImmutable();
        }

        if (empty($this->amount)) {
            // Prix de l'annonce * nombre de jour
            $this->amount = $this->adds->getPrice() * $this->getDuration();
        }
    }

    /**
     * Permet de savoir si les dates réservées sont disponibles ou non
     *
     * @return boolean
     */
    public function isBookableDates()
    {
        // 1. Il faut connaitre les dates qui sont impossibles pour l'annonce
        $notAvailableDays = $this->adds->getNotAvailableDays();
        // 2. Il faut comparer les dates choisies avec les dates impossibles
        $bookingDays = $this->getDays();

        $formatDay = function($day){
            return $day->format('Y-m-d');
        };

        // Tableau des chaines de caractères de mes journées
        $days = array_map($formatDay, $bookingDays);
        $notAvailable = array_map($formatDay, $notAvailableDays);

        foreach($days as $day) {
            if(array_search($day, $notAvailable) !== false) return false;
        }

        return true;
    }

    /**
     * Permet de récupérer un tableau des journées qui correspondent à ma réservation
     *
     * @return array Un tableau d'objets DateTimeImmutable représentant les jours de la réservation
     */
    public function getDays()
    {
        $resultat = range(
            $this->checkIn->getTimestamp(),
            $this->checkOut->getTimestamp(),
            24 * 60 * 60
        );

        $days =  array_map(function($dayTimestamp) {
            return new \DateTimeImmutable(date('Y-m-d', $dayTimestamp));
        }, $resultat);

        return $days;
    }

    public function getDuration()
    {
        $diff = $this->checkOut->diff($this->checkIn);
        return $diff->days;
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

    public function getCheckIn(): ?\DateTimeImmutable
    {
        return $this->checkIn;
    }

    public function setcheckIn(\DateTimeImmutable $checkIn): static
    {
        $this->checkIn = $checkIn;

        return $this;
    }

    public function getcheckOut(): ?\DateTimeImmutable
    {
        return $this->checkOut;
    }

    public function setcheckOut(\DateTimeImmutable $checkOut): static
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

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
