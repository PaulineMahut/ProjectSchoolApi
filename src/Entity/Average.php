<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AverageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AverageRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['read_average']], denormalizationContext: ['groups' => ['write_average']])]
class Average
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read_average', 'write_average'])]
    private $id;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(['read_average', 'write_average'])]
    private $rate;

    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'averages')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_average', 'write_average'])]
    private $student;

    #[ORM\ManyToOne(inversedBy: 'average', targetEntity: Subject::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read_average', 'write_average'])]
    private $subject;

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

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(Subject $subject): self
    {
        $this->subject = $subject;

        return $this;
    }
}
