<?php

namespace App\Entity\Main;

use App\Repository\PageRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class User
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
    private string  $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="The phone number should not be blank.")
     */
    private $phone;

    /**
     * @ORM\OneToOne (targetEntity=Address::class,mappedBy="user", cascade={"persist", "remove"})
     */
    private $address;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="string",nullable=false)
     */
    private $title;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private string $past;

    /**
     * @ORM\Column(type="date",nullable=false)
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="datetime",nullable=false)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="User",fetch="EXTRA_LAZY")



     */
    private $posts;


    /**
     * @ORM\OneToOne (targetEntity=User::class)
     * @ORM\JoinColumn(nullable=true,referencedColumnName="id")
     */
    private $invited_by;


    /**
     * @ORM\ManyToMany(targetEntity=SymfonyGroup::class, inversedBy="members", fetch="LAZY")

     * @ORM\JoinTable(name="user_groups")
     */
    private $groups;

    /**
     * @ORM\OneToMany(targetEntity=Page::class, mappedBy="user", orphanRemoval=true)
     */
    private $pages;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $dbid;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->groups = new ArrayCollection();
        $this->pages = new ArrayCollection();
    }

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return User
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPast()
    {
        return $this->past;
    }

    /**
     * @param mixed $past
     * @return User
     */
    public function setPast($past)
    {
        $this->past = $past;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param mixed $dateOfBirth
     * @return User
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvitedBy()
    {
        return $this->invited_by;
    }

    /**
     * @param mixed $invited_by
     * @return User
     */
    public function setInvitedBy( User $invited_by)
    {
        $this->invited_by = $invited_by;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getGroups(): ArrayCollection
    {
        return $this->groups;
    }

    /**
     * @param array $groups
     * @return User
     */
    public function setGroups(array $groups): User
    {
        $this->groups = $groups;
        return $this;
    }



    /**
     * @param SymfonyGroup $groups
     * @return User
     */
    public function joinGroup(SymfonyGroup $groups): User
    {
        $groups->addMember($this);
        $this->groups[] = $groups;
        return $this;
    }

    /**
     * @return Collection<int, Page>
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    /**
     * @return Collection<int, Page>
     */
    public function getPublishedPages(): Collection
    {
      return   $this->pages->matching(PageRepository::getPublishedCriteria());
    }

    public function addPage(Page $page): self
    {
        if (!$this->pages->contains($page)) {
            $this->pages[] = $page;
            $page->setUser($this);
        }

        return $this;
    }

    public function removePage(Page $page): self
    {
        if ($this->pages->removeElement($page)) {
            // set the owning side to null (unless already changed)
            if ($page->getUser() === $this) {
                $page->setUser(null);
            }
        }

        return $this;
    }
    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getDbid(): ?string
    {
        return $this->dbid;
    }

    public function setDbid(?string $dbid): self
    {
        $this->dbid = $dbid;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
