<?php

namespace App\ApiActions;

use App\Entity\Users\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final class GetMeAction extends AbstractController
{
    /**
     * @return User
     */
    public function __invoke(): User
    {
        /** @var User $user */
        $user = $this->getUser();
        if($user === null) {
            throw new AccessDeniedException();
        }
        return $user;
    }
}
