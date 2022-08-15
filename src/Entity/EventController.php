<?php

namespace App\Entity;

use App\Repository\EventControllerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventControllerRepository::class)]
class EventController
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
