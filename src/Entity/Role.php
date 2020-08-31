<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 */
class Role
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
    private $title;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="userRoles")
     */
    private $USERS;

    public function __construct()
    {
        $this->USERS = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUSERS(): Collection
    {
        return $this->USERS;
    }

    public function addUSER(User $uSER): self
    {
        if (!$this->USERS->contains($uSER)) {
            $this->USERS[] = $uSER;
        }

        return $this;
    }

    public function removeUSER(User $uSER): self
    {
        if ($this->USERS->contains($uSER)) {
            $this->USERS->removeElement($uSER);
        }

        return $this;
    }
}
