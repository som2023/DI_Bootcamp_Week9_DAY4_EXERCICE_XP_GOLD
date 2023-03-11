<?php

namespace App\Entity;

use App\Repository\RolesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RolesRepository::class)]
class Roles
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $role_id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    

    public function getRoleId(): ?int
    {
        return $this->role_id;
    }


    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function asArray(): array
    {
        return [
            'role_id' => $this->role_id,
            'nom' => $this->nom,
        ];
    }
}
