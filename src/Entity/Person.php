<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank([
            'message' => 'Please fill in your firstname',
    ])]
    #[Assert\Length([
            'min' => 2,
            'max' => 50,
            'minMessage' => 'Your firstname must be at least {{ limit }} characters long',
            'maxMessage' => 'Your firstname cannot be longer than {{ limit }} characters',
    ])]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank([
            'message' => 'Please fill in your lastname',
    ])]
    #[Assert\Length([
            'min' => 2,
            'max' => 50,
            'minMessage' => 'Your lastname must be at least {{ limit }} characters long',
            'maxMessage' => 'Your lastname cannot be longer than {{ limit }} characters',
        ])]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank([
            'message' => 'Please fill in your position',
    ])]
    #[Assert\Length([
            'min' => 2,
            'max' => 50,
            'minMessage' => 'Your position must be at least {{ limit }} characters long',
            'maxMessage' => 'Your position cannot be longer than {{ limit }} characters',
    ])]
    private ?string $position = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }
}
