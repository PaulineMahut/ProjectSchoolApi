<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProfessorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProfessorRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['read_professor']], denormalizationContext: ['groups' => ['write_professor']])]
class Professor extends User
{
    #[ORM\Column(type: 'integer')]
    #[Groups(['read_professor', 'write_professor'])]
    private $age;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['read_professor', 'write_professor'])]
    private $seniority;

    #[ORM\Column(type: 'integer')]
    #[Groups(['read_professor', 'write_professor'])]
    private $salary;

    #[ORM\OneToOne(inversedBy: 'professor', targetEntity: Classe::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_professor', 'write_professor'])]
    private $classe;

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getSeniority(): ?string
    {
        return $this->seniority;
    }

    public function setSeniority(string $seniority): self
    {
        $this->seniority = $seniority;

        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }
}
