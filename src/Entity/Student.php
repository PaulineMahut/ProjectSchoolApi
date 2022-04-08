<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['read_student']], denormalizationContext: ['groups' => ['write_student']])]
class Student extends User
{
    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['read_student', 'write_student'])]
    private $sexe;

    #[ORM\ManyToOne(targetEntity: Classe::class, inversedBy: 'student_id')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['read_student', 'write_student'])]
    private $classe;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: Average::class)]
    #[Groups(['read_student', 'write_student'])]
    private $averages;

    public function __construct()
    {
        $this->subjects = new ArrayCollection();
        $this->averages = new ArrayCollection();
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * @return Collection<int, Average>
     */
    public function getAverages(): Collection
    {
        return $this->averages;
    }

    public function addAverage(Average $average): self
    {
        if (!$this->averages->contains($average)) {
            $this->averages[] = $average;
            $average->setStudent($this);
        }

        return $this;
    }

    public function removeAverage(Average $average): self
    {
        if ($this->averages->removeElement($average)) {
            // set the owning side to null (unless already changed)
            if ($average->getStudent() === $this) {
                $average->setStudent(null);
            }
        }

        return $this;
    }

  
}
