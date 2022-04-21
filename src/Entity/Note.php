<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AverageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AverageRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['read_note']], denormalizationContext: ['groups' => ['write_note']])]
class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read_note', 'write_note'])]
    private $id;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(['read_note', 'write_note'])]
    private $rate;

    #[ORM\ManyToMany(targetEntity: Subject::class, mappedBy: 'notes')]
    #[Groups(['read_note', 'write_note'])]
    private $subjects;

    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'notes')]
    #[Groups(['read_note', 'write_note'])]
    private $student;

    public function __construct()
    {
        $this->subjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(?float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * @return Collection<int, Subject>
     */
    public function getSubjects(): Collection
    {
        return $this->subjects;
    }

    public function addSubject(Subject $subject): self
    {
        if (!$this->subjects->contains($subject)) {
            $this->subjects[] = $subject;
            $subject->addNote($this);
        }

        return $this;
    }

    public function removeSubject(Subject $subject): self
    {
        if ($this->subjects->removeElement($subject)) {
            $subject->removeNote($this);
        }

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

}
