<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvoiceRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="invoices")
 */
class Invoice
{
    const STATE_CREATED = 'created';
    const STATE_SENT = 'sent';
    const STATE_PAID = 'paid';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Recipient::class, mappedBy="invoice")
     */
    private $recipient;

    /**
     * @ORM\Column(type="float")
     */
    private $netAmount;

    /**
     * @ORM\Column(type="float")
     */
    private $grossAmount;

    /**
     * @ORM\Column(type="float")
     */
    private $vatAmount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state = self::STATE_CREATED;

    /**
     * @ORM\ManyToMany(targetEntity=Item::class, inversedBy="invoices")
     */
    private $items;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->recipient = new ArrayCollection();
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Recipient[]
     */
    public function getRecipient(): Collection
    {
        return $this->recipient;
    }

    public function addRecipient(Recipient $recipient): self
    {
        if (!$this->recipient->contains($recipient)) {
            $this->recipient[] = $recipient;
            $recipient->setInvoice($this);
        }

        return $this;
    }

    public function removeRecipient(Recipient $recipient): self
    {
        if ($this->recipient->removeElement($recipient)) {
            // set the owning side to null (unless already changed)
            if ($recipient->getInvoice() === $this) {
                $recipient->setInvoice(null);
            }
        }

        return $this;
    }

    public function getNetAmount(): ?float
    {
        return $this->netAmount;
    }

    public function setNetAmount(float $netAmount): self
    {
        $this->netAmount = $netAmount;

        return $this;
    }

    public function getGrossAmount(): ?float
    {
        return $this->grossAmount;
    }

    public function setGrossAmount(float $grossAmount): self
    {
        $this->grossAmount = $grossAmount;

        return $this;
    }

    public function getVatAmount(): ?float
    {
        return $this->vatAmount;
    }

    public function setVatAmount(float $vatAmount): self
    {
        $this->vatAmount = $vatAmount;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        if (!in_array($state, array(self::STATE_CREATED, self::STATE_SENT, self::STATE_PAID))) {
            throw new \InvalidArgumentException("Invalid state");
        }

        if($state === self::STATE_PAID && $this->state != self::STATE_SENT) {
            throw new \InvalidArgumentException("An invoice that was not sent to the customer yet cannot be set to paid.");
        }

        $this->state = $state;

        return $this;
    }

    /**
     * @return Collection|Item[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        $this->items->removeElement($item);

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @var string
     */
    public function setCreatedAtAutomatically(): void
    {
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime());
        }
    }
}
