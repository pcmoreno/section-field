<?php
declare (strict_types=1);

namespace Example\Blog\Entity;

use Tardigrades;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Comment
{
    /** @var Blog */
    protected $blog;

    /** @var string */
    protected $comment;

    /** @var string */
    protected $email;

    /** @var string */
    protected $name;

    /** @var int */
    private $id;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBlog(): ?Blog
    {
        return $this->blog;
    }

    public function hasBlog(): bool
    {
        return !empty($this->blog);
    }

    public function setBlog(Blog $blog): Comment
    {
        $this->blog = $blog;
        return $this;
    }

    public function removeBlog(): Comment
    {
        $this->blog = null;
        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): Comment
    {
        $this->comment = $comment;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): Comment
    {
        $this->email = $email;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): Comment
    {
        $this->name = $name;
        return $this;
    }

    public function getDefault(): string
    {
        return $this->name;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint('comment', new Assert\NotBlank());
    }

    public function onPrePersist(): void
    {
    }

    public function onPreUpdate(): void
    {
    }
}

