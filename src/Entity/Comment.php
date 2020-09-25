<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetime;

    /**
     * @ORM\Column(type="integer")
     */
    private $quack_id;

    /**
     * @ORM\ManyToOne(targetEntity=QuackEntity::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Quack;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getQuackId(): ?int
    {
        return $this->quack_id;
    }

    public function setQuackId(int $quack_id): self
    {
        $this->quack_id = $quack_id;

        return $this;
    }

    public function getQuack(): ?QuackEntity
    {
        return $this->Quack;
    }

    public function setQuack(?QuackEntity $Quack): self
    {
        $this->Quack = $Quack;

        return $this;
    }
}
