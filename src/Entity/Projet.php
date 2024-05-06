<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

   

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $duree = null;

    #[ORM\Column(length: 255)]
    private ?string $pre_requis = null;

    #[ORM\Column(length: 255)]
    private ?string $contenu = null;

    #[ORM\Column (nullable: false)]
    public ?bool $isValid = false;

    #[ORM\Column(length: 255 , nullable: true)]
    public ?string $validateBy = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDuree(): ?float
    {
        return $this->duree;
    }

    public function setDuree(float $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getPreRequis(): ?string
    {
        return $this->pre_requis;
    }

    public function setPreRequis(string $pre_requis): static
    {
        $this->pre_requis = $pre_requis;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }
}
