<?php

namespace App\Entity;

use App\Repository\GroupsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupsRepository::class)
 * @ORM\Table(name="symfony_group")
 */
class SymfonyGroup
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
    private  string $name;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="groups")
     */
    private $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getMembers(): ArrayCollection
    {
        return $this->members;
    }

    /**
     * @param User $member
     * @return SymfonyGroup
     */
    public function addMember(User $member): SymfonyGroup
    {
        $this->members [] = $member;
        return $this;
    }

    /**
     * @param User $member
     * @return SymfonyGroup
     */
    public function removeMember(User $member): SymfonyGroup
    {
        $this->members->removeElement($member);
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return SymfonyGroup
     */
    public function setName(string $name): SymfonyGroup
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param ArrayCollection $members
     * @return SymfonyGroup
     */
    public function setMembers(ArrayCollection $members): SymfonyGroup
    {
        $this->members = $members;
        return $this;
    }
}
