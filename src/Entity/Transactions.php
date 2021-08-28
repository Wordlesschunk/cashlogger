<?php

namespace App\Entity;

use App\Repository\TransactionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionsRepository::class)
 */
class Transactions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $moneyIn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $moneyOut;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMoneyIn(): ?string
    {
        return $this->moneyIn;
    }

    public function setMoneyIn(string $moneyIn): self
    {
        $this->moneyIn = $moneyIn;

        return $this;
    }

    public function getMoneyOut(): ?string
    {
        return $this->moneyOut;
    }

    public function setMoneyOut(string $moneyOut): self
    {
        $this->moneyOut = $moneyOut;

        return $this;
    }
}
