<?php

namespace App\Repository;

use App\Entity\Score;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Score>
 *
 * @method Score|null find($id, $lockMode = null, $lockVersion = null)
 * @method Score|null findOneBy(array $criteria, array $orderBy = null)
 * @method Score[]    findAll()
 * @method Score[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScoreRepository extends ServiceEntityRepository
{
    private object $registry;
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Score::class);
        $this->registry = $registry;
    }

    public function add(Score $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Score $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    public function create(string $term, float $score): bool
    {
        $entityManager = $this->registry->getManager();

        $scoreEntity = new Score();
    
        $scoreEntity->setTerm($term);
        $scoreEntity->setScore($score);
        
        $entityManager->persist($scoreEntity);
        $entityManager->flush();
    
        return true;
    }
    
    public function update(int $id, float $score) : bool
    {
        $entityManager = $this->registry->getManager();
        $scoreEntity = $entityManager->getRepository(Score::class)->find($id);
        if (!$scoreEntity) {
            return false;
        }
    
        $scoreEntity->setScore($score);
        $entityManager->flush();
        
        return true;
    }

//    /**
//     * @return Score[] Returns an array of Score objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
}
