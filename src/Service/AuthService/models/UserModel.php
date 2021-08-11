<?php


namespace App\Service\AuthService\models;


use App\Entity\Companies\Company;
use App\Entity\Users\User;
use App\Service\AuthService\exceptions\UserRegistrationException;
use App\Service\AuthService\utils\AuthServiceUtils;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

//TODO pass the user entity using env var or config
class UserModel
{
    /**
     * @var AuthServiceUtils
     */
    private $utils;
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordHasher;
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * UserModel constructor.
     * @param AuthServiceUtils $utils
     */
    public function __construct(AuthServiceUtils $utils,  UserPasswordHasherInterface $passwordHasher, ValidatorInterface $validator,  EntityManagerInterface $manager, LoggerInterface $logger)
    {
        $this->utils = $utils;
        $this->manager = $manager;
        $this->passwordHasher = $passwordHasher;
        $this->validator = $validator;
        $this->logger = $logger;
    }

    public function create(array $data, array $roles = ['ROLE_USER'])
    {
        $user = $this->utils->mapFieldsToEntity(new User(), $data);
        $user->setRoles($roles);
        $user->setPassword($this->passwordHasher->hashPassword($user, $data['plain_password']));

        return $user;
    }

    /**
     * @param User $user
     * @return User|ConstraintViolationListInterface
     * @throws UserRegistrationException
     */
    public function validate(User $user, $persist = true)
    {
        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            return $errors;
        }

        $user->setPlainPassword('');

        if($persist) {
            try{
                $this->manager->persist($user);
                $this->manager->flush();
            }catch (\Exception $e) {
                $this->logger->error($e);
                throw new UserRegistrationException('AuthService/UserModel: Unable to persist user', 500);
            }

        }

        return $user;
    }
}