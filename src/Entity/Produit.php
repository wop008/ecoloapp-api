<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=30)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $quantite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $origine;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img_url;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Label", cascade={"persist"})
     * @ORM\JoinTable(name="label_produit",
     *     joinColumns={@ORM\JoinColumn(name="produit_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="label_id", referencedColumnName="id")}
     *     )
     */
    private $labels;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Marque", cascade={"persist"})
     * @ORM\JoinTable(name="marque_produit",
     *     joinColumns={@ORM\JoinColumn(name="produit_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="marque_id", referencedColumnName="id")}
     *     )
     */
    private $marques;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Emballage", cascade={"persist"})
     * @ORM\JoinTable(name="emballage_produit",
     *     joinColumns={@ORM\JoinColumn(name="produit_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="emballage_id", referencedColumnName="id")}
     *     )
     */
    private $emballages;

    public function __construct()
    {
        $this->labels = new ArrayCollection();
        $this->marques = new ArrayCollection();
        $this->emballages = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getQuantite(): ?string
    {
        return $this->quantite;
    }

    public function setQuantite(string $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getOrigine(): ?string
    {
        return $this->origine;
    }

    public function setOrigine(string $origine): self
    {
        $this->origine = $origine;

        return $this;
    }

    public function getImgUrl(): ?string
    {
        return $this->img_url;
    }

    public function setImgUrl(string $img_url): self
    {
        $this->img_url = $img_url;

        return $this;
    }

    /**
     * @return Collection|Label[]
     */
    public function getLabels(): Collection
    {
        return $this->labels;
    }

    public function addLabel(Label $label): self
    {
        if (!$this->labels->contains($label)) {
            $this->labels[] = $label;
        }

        return $this;
    }

    public function removeLabel(Label $label): self
    {
        if ($this->labels->contains($label)) {
            $this->labels->removeElement($label);
        }

        return $this;
    }

    /**
     * @return Collection|Marque[]
     */
    public function getMarques(): Collection
    {
        return $this->marques;
    }

    public function addMarque(Marque $marque): self
    {
        if (!$this->marques->contains($marque)) {
            $this->marques[] = $marque;
        }

        return $this;
    }

    public function removeMarque(Marque $marque): self
    {
        if ($this->marques->contains($marque)) {
            $this->marques->removeElement($marque);
        }

        return $this;
    }

    /**
     * @return Collection|Emballage[]
     */
    public function getEmballages(): Collection
    {
        return $this->emballages;
    }

    public function addEmballage(Emballage $emballage): self
    {
        if (!$this->emballages->contains($emballage)) {
            $this->emballages[] = $emballage;
        }

        return $this;
    }

    public function removeEmballage(Emballage $emballage): self
    {
        if ($this->emballages->contains($emballage)) {
            $this->emballages->removeElement($emballage);
        }

        return $this;
    }

    /*public function __toString()
    {
        $finalString = 'Nom : '.$this->getNom().'; Quantite : '.$this->getQuantite().'; Origine : '.$this->getOrigine().'; Labels : ';
        foreach ($this->getLabels() as $label)
        {
            $finalString .= $label->__toString().', ';
        }
        $finalString .= 'Marques : ';
        foreach ($this->getMarques() as $marque)
        {
            $finalString .= $marque->__toString().', ';
        }
        $finalString .= 'Emballages : ';
        foreach ($this->getEmballages() as $emballage)
        {
            $finalString .= $emballage->__toString().', ';
        }

        return $finalString;
    }*/
}
