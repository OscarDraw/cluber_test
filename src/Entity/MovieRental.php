<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MovieRental
 *
 * @ORM\Table(name="movie_rental", indexes={@ORM\Index(name="fk_movie_rental_3", columns={"movie"}), @ORM\Index(name="fk_movie_rental_2", columns={"invoice"})})
 * @ORM\Entity
 */
class MovieRental
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
     * @ORM\Column(name="return_date", type="date", nullable=true)
     */
    private $returnDate;

    /**
     * @var int|null
     *
     * @ORM\Column(name="price", type="integer", nullable=true)
     */
    private $price;

    /**
     * @var int|null
     *
     * @ORM\Column(name="points", type="integer", nullable=true)
     */
    private $points;

    /**
     * @var \Movie
     *
     * @ORM\ManyToOne(targetEntity="Movie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="movie", referencedColumnName="id")
     * })
     */
    private $movie;

    /**
     * @var \Invoice
     *
     * @ORM\ManyToOne(targetEntity="Invoice")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="invoice", referencedColumnName="id")
     * })
     */
    private $invoice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->returnDate;
    }

    public function setReturnDate(?\DateTimeInterface $returnDate): self
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }


}
