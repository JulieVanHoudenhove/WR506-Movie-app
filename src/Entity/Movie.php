<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[ApiResource(
    normalizationContext: [
        'groups' => ['movie:read'],
    ]
)]
#[ApiResource(security: "is_granted('ROLE_USER')")]
#[Get(security: "is_granted('ROLE_USER') or is_granted('ROLE_ADMIN')") ]
#[Put(security: "is_granted('ROLE_ADMIN') or object.owner == user")]
#[GetCollection]
#[Post(security: "is_granted('ROLE_ADMIN')")]
#[ApiFilter(BooleanFilter::class, properties: ['online' => 'exact'])]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['movie:read', 'actor:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'The title is necessary')]
    #[ApiFilter(SearchFilter::class, strategy: 'partial')]
    #[Groups(['movie:read', 'actor:read'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'The description is necessary')]
    #[Assert\NotNull(message: 'The description is necessary')]
    #[Assert\Length(min: 50, minMessage: 'The movie description should be 50 characters minimum')]
    #[Groups(['movie:read', 'actor:read'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['movie:read', 'actor:read'])]
    #[Assert\Type('\DateTimeInterface')]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type('integer')]
    #[Assert\GreaterThan(value: 15, message: 'The movie should be 15 minutes minimum')]
    #[Groups(['movie:read', 'actor:read'])]
    private ?int $duration = null;

    #[ORM\ManyToMany(targetEntity: Actor::class, inversedBy: 'movies')]
    #[Groups(['movie:read'])]
    private Collection $actor;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    #[Groups(['movie:read'])]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    #[Groups(['movie:read'])]
    private ?user $user = null;

    #[ORM\Column]
    #[Groups(['movie:read'])]
    private ?bool $online = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['movie:read'])]
    #[Assert\Type('float')]
    #[Assert\Range(notInRangeMessage: 'The note should be between {{ min }} and {{ max }}', min: 0, max: 5)]
    private ?float $note = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['movie:read'])]
    #[Assert\Type('integer')]
    private ?int $entries = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['movie:read'])]
    #[Assert\Type('integer')]
    private ?int $budget = null;

    #[ORM\Column(length: 255)]
    #[Groups(['movie:read'])]
    #[Assert\Type('string')]
    #[Assert\NotBlank(message: 'The director is necessary')]
    #[Assert\NotNull(message: 'The director is necessary')]
    private ?string $director = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['movie:read'])]
    #[Assert\Type('string')]
    #[Assert\Url(message: 'The url {{ value }} is not a valid url')]
    private ?string $website = null;

    public function __construct()
    {
        $this->actor = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Actor>
     */
    public function getActor(): Collection
    {
        return $this->actor;
    }

    public function addActor(Actor $actor): static
    {
        if (!$this->actor->contains($actor)) {
            $this->actor->add($actor);
        }

        return $this;
    }

    public function removeActor(Actor $actor): static
    {
        $this->actor->removeElement($actor);

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function isOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): static
    {
        $this->online = $online;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(?float $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getEntries(): ?int
    {
        return $this->entries;
    }

    public function setEntries(?int $entries): static
    {
        $this->entries = $entries;

        return $this;
    }

    public function getBudget(): ?int
    {
        return $this->budget;
    }

    public function setBudget(?int $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(string $director): static
    {
        $this->director = $director;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): static
    {
        $this->website = $website;

        return $this;
    }
}
