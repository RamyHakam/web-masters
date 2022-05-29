<?php

namespace App\Entity\Main;

use App\Repository\Main\CustomerDbConfigRepository;
use Doctrine\ORM\Mapping as ORM;
use Hakam\MultiTenancyBundle\Services\TenantDbConfigurationInterface;
use Hakam\MultiTenancyBundle\Traits\TenantDbConfigTrait;

/**
 * @ORM\Entity(repositoryClass=CustomerDbConfigRepository::class)
 */
class CustomerDbConfig implements  TenantDbConfigurationInterface
{
    use TenantDbConfigTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
