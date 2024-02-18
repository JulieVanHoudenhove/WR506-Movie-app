<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\NationalityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NationalityRepository::class)]
#[ApiResource(security: "is_granted('ROLE_USER')")]
#[Get]
#[Put(security: "is_granted('ROLE_ADMIN') or object.owner == user")]
#[GetCollection]
#[Post(security: "is_granted('ROLE_ADMIN')")]
class Nationality
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['actor:read'])]
    #[Assert\Type('string')]
    #[Assert\NotNull]
    private ?string $nationality = null;

    #[ORM\OneToMany(mappedBy: 'nationality', targetEntity: Actor::class)]
    private Collection $actors;

    public function __construct()
    {
        $this->actors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection<int, Actor>
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    public function addActor(Actor $actor): static
    {
        if (!$this->actors->contains($actor)) {
            $this->actors->add($actor);
            $actor->setNationality($this);
        }

        return $this;
    }

    public function removeActor(Actor $actor): static
    {
        if ($this->actors->removeElement($actor)) {
            // set the owning side to null (unless already changed)
            if ($actor->getNationality() === $this) {
                $actor->setNationality(null);
            }
        }

        return $this;
    }
}
