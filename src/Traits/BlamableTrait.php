<?php

namespace App\Traits;

use App\Entity\Users\User;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait BlamableTrait
{
    /**
     * @ORM\ManyToOne(targetEntity=User::class, fetch="LAZY")
     * @ORM\ManyToOne(targetEntity="User")
     * @Gedmo\Blameable(on="create")
     */
    private $createdBy;
    
    /**
     * @ORM\ManyToOne(targetEntity=User::class, fetch="LAZY")
     * @Gedmo\Blameable(on="update")
     */
    private $updatedBy;
    
    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }
    
    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;
        
        return $this;
    }
    
    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }
    
    public function setUpdatedBy(?User $updatedBy): self
    {
        $this->updatedBy = $updatedBy;
        
        return $this;
    }
}
