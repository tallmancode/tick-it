<?php


namespace App\DataPersisters;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Coupons\Coupon;
use App\Entity\Enrichments\Enrichment;
use App\Entity\Tickets\Ticket;
use App\Entity\Tickets\TicketStatus;
use App\Service\CouponService;
use App\Service\MailService\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class TicketDataPersister implements ContextAwareDataPersisterInterface
{
    private ContextAwareDataPersisterInterface $decorated;
    private EntityManagerInterface $entityManager;
    private TokenGeneratorInterface $tokenGenerator;
    private MailService $mailService;

    public function __construct(ContextAwareDataPersisterInterface $decorated, EntityManagerInterface $entityManager, MailService $mailService, TokenGeneratorInterface $tokenGenerator)
    {
        $this->decorated = $decorated;
        $this->entityManager = $entityManager;
        $this->tokenGenerator = $tokenGenerator;
        $this->mailService = $mailService;
    }

    public function supports($data, array $context = []): bool
    {
        return $this->decorated->supports($data, $context);
    }

    public function persist($data, array $context = [])
    {
        if ($data instanceof Ticket && (($context['collection_operation_name'] ?? null) === 'post')) {
            if($data->getTicketStatus() === null || $data->getTicketStatus() === ''){
                $ticketStatus = $this->entityManager->getRepository(TicketStatus::class)->findOneBy(['name' => 'new']);
                $data->setTicketStatus($ticketStatus);
            }

            $token = $this->tokenGenerator->generateToken();
            $data->setToken($token);


            $this->mailService->sendEmail($data->getCustomer()->getEmail(),'New Tick It Logged', 'mail/ticket_created_mail.html.twig', ['ticket'=> $data, 'token' => $token ]);

        }
        return $this->decorated->persist($data, $context);
    }

    public function remove($data, array $context = [])
    {
        return $this->decorated->remove($data, $context);
    }
}