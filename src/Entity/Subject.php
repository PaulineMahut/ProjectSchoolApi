<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SubjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SubjectRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['read_subject']], denormalizationContext: ['groups' => ['write_subject']])]
class Subject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read_subject', 'write_subject'])]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['read_subject', 'write_subject'])]
    private $name;

    #[ORM\OneToMany(mappedBy: 'subject', targetEntity: Average::class, cascade: ['persist', 'remove'])]
    #[Groups(['read_subject', 'write_subject'])]
    private $average;

    public function __construct()
    {
        $this->student = new ArrayCollection();
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

    public function getAverage(): ?Average
    {
        return $this->average;
    }

    public function setAverage(Average $average): self
    {
        // set the owning side of the relation if necessary
        if ($average->getSubject() !== $this) {
            $average->setSubject($this);
        }

        $this->average = $average;

        return $this;
    }
}
