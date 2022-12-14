<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Contact;
use App\Exception\NotFoundException;
use App\Exception\UniqueException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contact>
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    /**
     * @return array<Contact>
     */
    public function list(int $limit, int $offset): array
    {
        return $this->findBy([], ['id' => 'DESC'], $limit, $offset);
    }

    /**
     * @throws NotFoundException
     */
    public function get(int $id): Contact
    {
        $contact = $this->find($id);

        if ($contact === null) {
            throw new NotFoundException('Contact not found. ID: ' . $id);
        }

        return $contact;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NotFoundException
     */
    public function getByUsername(string $username): Contact
    {
        $contact = $this->findByUsername($username);

        if ($contact === null) {
            throw new NotFoundException('Contact not found. Username: ' . $username);
        }

        return $contact;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findByUsername(string $username): ?Contact
    {
        $qb = $this->createQueryBuilder('c');

        $qb->andWhere($qb->expr()->eq('c.username', ':username'))
            ->setParameter('username', $username);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws UniqueException
     */
    public function store(Contact $contact): Contact
    {
        $em = $this->getEntityManager();

        $em->persist($contact);

        try {
            $em->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new UniqueException('Contact already exists.', 0, $e);
        }

        return $contact;
    }

    public function remove(Contact $contact): void
    {
        $em = $this->getEntityManager();

        $em->remove($contact);
        $em->flush();
    }
}
