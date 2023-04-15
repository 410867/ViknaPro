<?php

namespace App\Entity;

use App\Object\Service\ServiceWhyWe;
use App\Repository\ServiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service implements SluggerEntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptionShort = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mainImg = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $textImg = null;

    #[NotBlank]
    #[Count(min: 4, max: 4)]
    #[ORM\Column]
    private array $workSteps = ['', '', '', ''];

    /**
     * @var array<ServiceWhyWe>
     */
    #[NotBlank]
    #[Count(min: 1)]
    #[ORM\Column]
    private array $whyWe = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?int $sort = 0;

    public function __construct()
    {
        $this->whyWe[] = new ServiceWhyWe();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescriptionShort(): ?string
    {
        return $this->descriptionShort;
    }

    public function setDescriptionShort(?string $descriptionShort): self
    {
        $this->descriptionShort = $descriptionShort;

        return $this;
    }

    public function getMainImg(): ?string
    {
        return $this->mainImg;
    }

    public function setMainImg(?string $mainImg): self
    {
        $this->mainImg = $mainImg;

        return $this;
    }

    public function getTextImg(): ?string
    {
        return $this->textImg;
    }

    public function setTextImg(?string $textImg): self
    {
        $this->textImg = $textImg;

        return $this;
    }

    public function getWorkSteps(): array
    {
        return $this->workSteps;
    }

    public function setWorkSteps(array $workSteps): self
    {
        $this->workSteps = $workSteps;

        return $this;
    }

    /**
     * @return array<ServiceWhyWe>
     */
    public function getWhyWe(): array
    {
        foreach ($this->whyWe as $k => $item){
            if (is_array($item) || null === $item) {
                $this->whyWe[$k] = ServiceWhyWe::newFromArray($item);
            }
        }

        return $this->whyWe;
    }

    /**
     * @param array<ServiceWhyWe> $whyWe
     */
    public function setWhyWe(array $whyWe): void
    {
        $this->whyWe = $whyWe;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     */
    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return int|null
     */
    public function getSort(): ?int
    {
        return $this->sort;
    }

    /**
     * @param int|null $sort
     */
    public function setSort(?int $sort): void
    {
        $this->sort = $sort;
    }
}
