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
     * @ORM\Column(type="string")
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
    private $dest_ville;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Etape", mappedBy="ville_etape", orphanRemoval=true)
     */
    private $etapes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    public function __construct()
    {
        $this->etapes = new ArrayCollection();
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

    public function getDestVille(): ?Destination
    {
        return $this->dest_ville;
    }

    public function setDestVille(?Destination $dest_ville): self
    {
        $this->dest_ville = $dest_ville;

        return $this;
    }

    /**
     * @return Collection|Etape[]
     */
    public function getEtapes(): Collection
    {
        return $this->etapes;
    }

    public function addEtape(Etape $etape): self
    {
        if (!$this->etapes->contains($etape)) {
            $this->etapes[] = $etape;
            $etape->setVilleEtape($this);
        }

        return $this;
    }

    public function removeEtape(Etape $etape): self
    {
        if ($this->etapes->contains($etape)) {
            $this->etapes->removeElement($etape);
            // set the owning side to null (unless already changed)
            if ($etape->getVilleEtape() === $this) {
                $etape->setVilleEtape(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
