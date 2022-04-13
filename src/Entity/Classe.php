<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['read_classe']], denormalizationContext: ['groups' => ['write_classe']])]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read_classe', 'write_classe'])]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['read_classe', 'write_classe'])]
    private $name;

    #[ORM\OneToMany(mappedBy: 'classe', targetEntity: Student::class)]
    #[Groups(['read_classe', 'write_classe'])]
    private $student_id;

    #[ORM\OneToOne(mappedBy: 'classe', targetEntity: Professor::class)]
    #[Groups(['read_classe', 'write_classe'])]
    private $professor;

    public function __construct()
    {
        $this->student_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudentId(): Collection
    {
        return $this->student_id;
    }

    public function addStudentId(Student $studentId): self
    {
        if (!$this->student_id->contains($studentId)) {
            $this->student_id[] = $studentId;
            $studentId->setClasse($this);
        }

        return $this;
    }

    public function removeStudentId(Student $studentId): self
    {
        if ($this->student_id->removeElement($studentId)) {
            // set the owning side to null (unless already changed)
            if ($studentId->getClasse() === $this) {
                $studentId->setClasse(null);
            }
        }

        return $this;
    }

    public function getProfessor(): ?Professor
    {
        return $this->professor;
    }

    public function setProfessor(Professor $professor): self
    {
        // set the owning side of the relation if necessary
        if ($professor->getClasse() !== $this) {
            $professor->setClasse($this);
        }

        $this->professor = $professor;

        return $this;
    }
}
