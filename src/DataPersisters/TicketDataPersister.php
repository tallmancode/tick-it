<?php


namespace App\DataPersisters;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Coupons\Coupon;
use App\Entity\Enrichments\Enrichment;
use App\Entity\Tickets\Ticket;
use App\Entity\Tickets\TicketStatus;
use App\Service\CouponService;
use Doctrine\ORM\EntityManagerInterface;

class TicketDataPersister implements ContextAwareDataPersisterInterface
{
    private ContextAwareDataPersisterInterface $decorated;
    private EntityManagerInterface $entityManager;

    public function __construct(ContextAwareDataPersisterInterface $decorated, EntityManagerInterface $entityManager)
    {
        $this->decorated = $decorated;
        $this->entityManager = $entityManager;
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
        }
        return $this->decorated->persist($data, $context);
    }

    public function remove($data, array $context = [])
    {
        return $this->decorated->remove($data, $context);
    }
}