<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    #[ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    #[JoinColumn(onDelete: 'SET NULL')]
    private null|Category $category = null;

    #[ManyToOne(targetEntity: CategoryCollection::class, inversedBy: 'products')]
    #[JoinColumn(onDelete: 'SET NULL')]
    private null|CategoryCollection $collection = null;

    #[ORM\Column]
    private ?int $sort = 0;

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

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

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

    public function getCollection(): ?CategoryCollection
    {
        return $this->collection;
    }

    public function setCollection(?CategoryCollection $collection): self
    {
        $this->collection = $collection;

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
