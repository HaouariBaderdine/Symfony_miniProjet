<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VilleRepository")
 */
class Ville
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
    private $code_ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $des_ville;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Destination", inversedBy="villes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $code_dest;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EtapeCircuit", mappedBy="code_ville")
     */
    private $etapeCircuits;

    public function __construct()
    {
        $this->etapeCircuits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeVille(): ?string
    {
        return $this->code_ville;
    }

    public function setCodeVille(string $code_ville): self
    {
        $this->code_ville = $code_ville;

        return $this;
    }

    public function getDesVille(): ?string
    {
        return $this->des_ville;
    }

    public function setDesVille(string $des_ville): self
    {
        $this->des_ville = $des_ville;

        return $this;
    }

    public function getCodeDest(): ?Destination
    {
        return $this->code_dest;
    }

    public function setCodeDest(?Destination $code_dest): self
    {
        $this->code_dest = $code_dest;

        return $this;
    }

    /**
     * @return Collection|EtapeCircuit[]
     */
    public function getEtapeCircuits(): Collection
    {
        return $this->etapeCircuits;
    }

    public function addEtapeCircuit(EtapeCircuit $etapeCircuit): self
    {
        if (!$this->etapeCircuits->contains($etapeCircuit)) {
            $this->etapeCircuits[] = $etapeCircuit;
            $etapeCircuit->setCodeVille($this);
        }

        return $this;
    }

    public function removeEtapeCircuit(EtapeCircuit $etapeCircuit): self
    {
        if ($this->etapeCircuits->contains($etapeCircuit)) {
            $this->etapeCircuits->removeElement($etapeCircuit);
            // set the owning side to null (unless already changed)
            if ($etapeCircuit->getCodeVille() === $this) {
                $etapeCircuit->setCodeVille(null);
            }
        }

        return $this;
    }
}
