<?php


namespace App\DataPersisters;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Coupons\Coupon;
use App\Entity\Enrichments\Enrichment;
use App\Entity\Tickets\Reply;
use App\Entity\Tickets\Ticket;
use App\Entity\Tickets\TicketStatus;
use App\Service\CouponService;
use App\Service\MailService\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class ReplyDataPersister implements ContextAwareDataPersisterInterface
{
    private ContextAwareDataPersisterInterface $decorated;
    private EntityManagerInterface $entityManager;
    private MailService $mailService;
    private TokenGeneratorInterface $tokenGenerator;

    public function __construct(ContextAwareDataPersisterInterface $decorated, EntityManagerInterface $entityManager, MailService $mailService, TokenGeneratorInterface $tokenGenerator)
    {
        $this->decorated = $decorated;
        $this->entityManager = $entityManager;
        $this->mailService = $mailService;
        $this->tokenGenerator = $tokenGenerator;
    }

    public function supports($data, array $context = []): bool
    {
        return $this->decorated->supports($data, $context);
    }

    public function persist($data, array $context = [])
    {
        if ($data instanceof Reply && (($context['collection_operation_name'] ?? null) === 'post')) {
            $token = $this->tokenGenerator->generateToken();
            $this->mailService->sendEmail('test@test.com','test', 'mail/support_mail.html.twig', ['reply'=> $data, 'token' => $token]);
           dump($data);
        }
        return $this->decorated->persist($data, $context);
    }

    public function remove($data, array $context = [])
    {
        return $this->decorated->remove($data, $context);
    }
}