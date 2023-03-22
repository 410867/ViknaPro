<?php

namespace App\Entity;

use App\Object\Category\CategoryTemplateEnum;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $sort = 0;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    #[OneToMany(mappedBy: 'parent', targetEntity: Category::class)]
    private Collection $children;

    #[ManyToOne(targetEntity: Category::class, inversedBy: 'children')]
    #[JoinColumn(name: 'parent_id', referencedColumnName: 'id', onDelete: 'SET NULL')]
    private null|Category $parent = null;

    #[ORM\Column(length: 255, nullable: true)]
    private null|string $nesting = null;

    #[OneToMany(mappedBy: 'category', targetEntity: CategoryCollection::class)]
    private Collection $categoryCollection;

    #[Column(type: 'string', enumType: CategoryTemplateEnum::class)]
    public CategoryTemplateEnum $template = CategoryTemplateEnum::SUB_CATEGORIES;

    #[Column(type: 'json', nullable: true)]
    public ?array $images = null;

    #[Column(type: 'json', nullable: true)]
    public ?array $videoLinks = null;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->categoryCollection = new ArrayCollection();
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

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): void
    {
        $this->img = $img;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getChildren(): Collection
    {
        $criteria = new Criteria();
        $criteria->orderBy(['sort' => 'ASC']);

        return $this->children->matching($criteria);
    }

    public function addChild(Category $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(Category $child): self
    {
        if ($this->children->removeElement($child)) {
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    public function getParent(): null|self
    {
        return $this->parent;
    }

    public function setParent(null|self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getNesting(): null|string
    {
        return $this->nesting;
    }

    public function setNesting(null|string $nesting): self
    {
        $this->nesting = $nesting;
        return $this;
    }

    /**
     * @return Collection<int, CategoryCollection>
     */
    public function getCategoryCollection(): Collection
    {
        return $this->categoryCollection;
    }

    public function addCategoryCollection(CategoryCollection $categoryCollection): self
    {
        if (!$this->categoryCollection->contains($categoryCollection)) {
            $this->categoryCollection->add($categoryCollection);
            $categoryCollection->setCategory($this);
        }

        return $this;
    }

    public function removeCategoryCollection(CategoryCollection $categoryCollection): self
    {
        if ($this->categoryCollection->removeElement($categoryCollection)) {
            // set the owning side to null (unless already changed)
            if ($categoryCollection->getCategory() === $this) {
                $categoryCollection->setCategory(null);
            }
        }

        return $this;
    }

    public function getTemplate(): CategoryTemplateEnum
    {
        return $this->template;
    }

    public function setTemplate(CategoryTemplateEnum $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function getImages(): array
    {
        return $this->images ?? [];
    }

    public function setImages(?array $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function getVideoLinks(): array
    {
        return $this->videoLinks;
    }

    public function setVideoLinks(?array $videoLinks): self
    {
        $this->videoLinks = $videoLinks;

        return $this;
    }
}
