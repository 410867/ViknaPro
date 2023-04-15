<?php

namespace App\Object\Service;

use JsonSerializable;

class ServiceWhyWe implements JsonSerializable
{
    private ?string $title = null;
    private ?string $description = null;

    public static function newFromArray(?array $data): ServiceWhyWe
    {
        $res = new self();
        foreach (get_object_vars($res) as $attribute => $defaultValue) {
            $res->$attribute = $data[$attribute] ?? $defaultValue;
        }

        return $res;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
