<?php

namespace App\Service\AuthService;

use App\Entity\Companies\Company;
use App\Entity\Users\User;
use App\Service\AuthService\models\CompanyModel;
use App\Service\AuthService\models\UserModel;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthService
{
    /**
     * @var UserModel
     */
    private $userModel;
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * AuthService constructor.
     * @param UserModel $userModel
     */
    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * @param $data
     * @return User|ConstraintViolationListInterface
     * @throws exceptions\UserRegistrationException
     */
    public function registerUser($data)
    {
        $user = $this->userModel->create($data);
        return $this->userModel->validate($user);
    }
}