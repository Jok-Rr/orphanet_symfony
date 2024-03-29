<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column()]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  private ?string $title = null;

  #[ORM\Column(length: 255)]
  private ?string $content = null;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $external_url = null;

  #[ORM\Column(type: Types::TEXT, nullable: true)]
  private ?string $header = null;

  #[ORM\Column(length: 255, nullable: true)]
  private ?string $hero_pic = null;

  #[ORM\Column(length: 255)]
  private ?string $slug = null;

  #[ORM\Column]
  private ?\DateTimeImmutable $created_at = null;

  #[ORM\Column(nullable: true)]
  private ?\DateTimeImmutable $updated_at = null;

  #[ORM\Column]
  private ?\DateTimeImmutable $event_date = null;

  #[ORM\Column(length: 255)]
  private ?string $event_place = null;

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

  public function getContent(): ?string
  {
    return $this->content;
  }

  public function setContent(string $content): self
  {
    $this->content = $content;

    return $this;
  }

  public function getExternalUrl(): ?string
  {
    return $this->external_url;
  }

  public function setExternalUrl(?string $external_url): self
  {
    $this->external_url = $external_url;

    return $this;
  }

  public function getHeader(): ?string
  {
    return $this->header;
  }

  public function setHeader(?string $header): self
  {
    $this->header = $header;

    return $this;
  }

  public function getHeroPic(): ?string
  {
    return $this->hero_pic;
  }

  public function setHeroPic(?string $hero_pic): self
  {
    $this->hero_pic = $hero_pic;

    return $this;
  }

  public function getSlug(): ?string
  {
    return $this->slug;
  }

  public function setSlug(string $slug): self
  {
    $this->slug = $slug;

    return $this;
  }

  public function getCreatedAt(): ?\DateTimeImmutable
  {
    return $this->created_at;
  }

  public function setCreatedAt(\DateTimeImmutable $created_at): self
  {
    $this->created_at = $created_at;

    return $this;
  }

  public function getUpdatedAt(): ?\DateTimeImmutable
  {
    return $this->updated_at;
  }

  public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
  {
    $this->updated_at = $updated_at;

    return $this;
  }

  public function getEventDate(): ?\DateTimeImmutable
  {
    return $this->event_date;
  }

  public function setEventDate(\DateTimeImmutable $event_date): self
  {
    $this->event_date = $event_date;

    return $this;
  }

  public function getEventPlace(): ?string
  {
    return $this->event_place;
  }

  public function setEventPlace(string $event_place): self
  {
    $this->event_place = $event_place;

    return $this;
  }
}