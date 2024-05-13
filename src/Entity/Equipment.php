<?php

namespace App\Entity;

use App\Repository\EquipmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipmentRepository::class)]
class Equipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Add>
     */
    #[ORM\ManyToMany(targetEntity: Add::class, inversedBy: 'equipment')]
    private Collection $adds;

    public function __construct()
    {
        $this->adds = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Add>
     */
    public function getAdds(): Collection
    {
        return $this->adds;
    }

    public function addAdd(Add $add): static
    {
        if (!$this->adds->contains($add)) {
            $this->adds->add($add);
        }

        return $this;
    }

    public function removeAdd(Add $add): static
    {
        $this->adds->removeElement($add);

        return $this;
    }
}
