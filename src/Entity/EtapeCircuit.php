<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtapeCircuitRepository")
 */
class EtapeCircuit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville", inversedBy="etapeCircuits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $code_ville;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Circuit", inversedBy="etapeCircuits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $code_circuit;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree_etape;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordre_etape;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeVille(): ?Ville
    {
        return $this->code_ville;
    }

    public function setCodeVille(?Ville $code_ville): self
    {
        $this->code_ville = $code_ville;

        return $this;
    }

    public function getCodeCircuit(): ?Circuit
    {
        return $this->code_circuit;
    }

    public function setCodeCircuit(?Circuit $code_circuit): self
    {
        $this->code_circuit = $code_circuit;

        return $this;
    }

    public function getDureeEtape(): ?int
    {
        return $this->duree_etape;
    }

    public function setDureeEtape(int $duree_etape): self
    {
        $this->duree_etape = $duree_etape;

        return $this;
    }

    public function getOrdreEtape(): ?int
    {
        return $this->ordre_etape;
    }

    public function setOrdreEtape(int $ordre_etape): self
    {
        $this->ordre_etape = $ordre_etape;

        return $this;
    }
}
