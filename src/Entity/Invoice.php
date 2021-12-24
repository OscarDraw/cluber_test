<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Invoice
 *
 * @ORM\Table(name="invoice", indexes={@ORM\Index(name="fk_invoice_1", columns={"customer"})})
 * @ORM\Entity
 */
class Invoice
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="rental_start_date", type="date", nullable=true)
     */
    private $rentalStartDate;

    /**
     * @var \Costumer
     *
     * @ORM\ManyToOne(targetEntity="Costumer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer", referencedColumnName="id")
     * })
     */
    private $customer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRentalStartDate(): ?\DateTimeInterface
    {
        return $this->rentalStartDate;
    }

    public function setRentalStartDate(?\DateTimeInterface $rentalStartDate): self
    {
        $this->rentalStartDate = $rentalStartDate;

        return $this;
    }

    public function getCustomer(): ?Costumer
    {
        return $this->customer;
    }

    public function setCustomer(?Costumer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }


}
