<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Costumer
 *
 * @ORM\Table(name="costumer")
 * @ORM\Entity
 */
class Costumer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var int|null
     *
     * @ORM\Column(name="loyalty_points", type="integer", nullable=true)
     */
    private $loyaltyPoints;

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

    public function getLoyaltyPoints(): ?int
    {
        return $this->loyaltyPoints;
    }

    public function setLoyaltyPoints(?int $loyaltyPoints): self
    {
        $this->loyaltyPoints = $loyaltyPoints;

        return $this;
    }


}
