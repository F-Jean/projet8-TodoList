<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @template-extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    /**
     * TaskRepository constructor
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }


    /**
     * TaskRepository function
     *
     * @param integer $page
     * @param integer $length
     * @return array<string, mixed>
     */
    public function getTasksToDo(int $page, int $length): array
    {
        $length = abs($length);

        $result = [];

        $queryBuilder = $this->createQueryBuilder('t')
            ->where("t.isDone = '0'")
            ->orderBy('t.id', 'asc')
            ->setFirstResult(($page - 1) * $length)
            ->setMaxResults($length);

        $paginator = new Paginator($queryBuilder);
        // On va chercher les données.
        /* @var array<array-key, Task> $data */
        $data = $paginator->getQuery()->getResult();

        // On calcule le nombre de pages.
        $pages = (int)ceil($paginator->count() / $length);

        // On remplit le tableau des infos requises pour faire la pagination dans la vue.
        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['length'] = $length;

        return $result;
    }

    /**
     * Taskrepository function
     *
     * @param integer $page
     * @param integer $length
     * @return array<string, mixed>
     */
    public function getTasksDone(int $page, int $length): array
    {
        $length = abs($length);

        $result = [];

        $queryBuilder = $this->createQueryBuilder('t')
            ->where("t.isDone = '1'")
            ->orderBy('t.id', 'asc')
            ->setFirstResult(($page - 1) * $length)
            ->setMaxResults($length);

        $paginator = new Paginator($queryBuilder);
        // On va chercher les données.
        $data = $paginator->getQuery()->getResult();

        // On calcule le nombre de pages.
        $pages = ceil($paginator->count() / $length);

        // On remplit le tableau des infos requises pour faire la pagination dans la vue.
        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['length'] = $length;

        return $result;
    }
}
