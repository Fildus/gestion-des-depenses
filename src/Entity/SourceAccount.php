<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SourceAccountRepository")
 */
class SourceAccount
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Expenditure", mappedBy="sourceAccount")
     */
    private $expenditures;

    public function __construct()
    {
        $this->expenditures = new ArrayCollection();
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
     * @return Collection|Expenditure[]
     */
    public function getExpenditures(): Collection
    {
        return $this->expenditures;
    }

    public function addExpenditure(Expenditure $expenditure): self
    {
        if (!$this->expenditures->contains($expenditure)) {
            $this->expenditures[] = $expenditure;
            $expenditure->setSourceAccount($this);
        }

        return $this;
    }

    public function removeExpenditure(Expenditure $expenditure): self
    {
        if ($this->expenditures->contains($expenditure)) {
            $this->expenditures->removeElement($expenditure);
            // set the owning side to null (unless already changed)
            if ($expenditure->getSourceAccount() === $this) {
                $expenditure->setSourceAccount(null);
            }
        }

        return $this;
    }
}
