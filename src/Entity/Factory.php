<?php

namespace App\Entity;

use App\Repository\FactoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: FactoryRepository::class)]
class Factory implements SluggerEntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $img = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[OneToMany(mappedBy: 'factory', targetEntity: CategoryCollection::class)]
    private Collection $categoryCollection;

    #[ManyToOne(targetEntity: Category::class, inversedBy: 'factories')]
    #[JoinColumn(onDelete: 'SET NULL')]
    private null|Category $category = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?int $sort = 0;

    public function __construct()
    {
        $this->categoryCollection = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, CategoryCollection>
     */
    public function getCategoryCollection(): Collection
    {
        $criteria = new Criteria();
        $criteria->orderBy(['sort' => 'ASC']);

        return $this->categoryCollection->matching($criteria);
    }

    public function addCategoryCollection(CategoryCollection $categoryCollection): self
    {
        if (!$this->categoryCollection->contains($categoryCollection)) {
            $this->categoryCollection->add($categoryCollection);
            $categoryCollection->setFactory($this);
        }

        return $this;
    }

    public function removeCategoryCollection(CategoryCollection $categoryCollection): self
    {
        if ($this->categoryCollection->removeElement($categoryCollection)) {
            // set the owning side to null (unless already changed)
            if ($categoryCollection->getFactory() === $this) {
                $categoryCollection->setFactory(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
}
