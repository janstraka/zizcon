<?php

namespace Model\base;

use Kdyby;
use Kdyby\Doctrine\EntityManager;
use Nette;
use Nette\Object;


class BaseService extends Object
{
    private $em;
    private $repository;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em, $repository = null)
    {
        $this->em = $em;
        $this->repository = $repository;
    }


    ///////////////////// EM based

    public function save($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function update($entity, $values)
    {
        $this->setData($entity, $values);
        $this->save($entity);
        return $entity;
    }

    public function delete($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    protected function setData($entity, $values)
    {
        foreach ($values as $key => $value) {
            $method = "set" . ucfirst($key);
            $entity->$method($value);
        }
    }

    ///////////////////// Repository based

    public function find($id = null)
    {
        if(!$id){
            $id = 0;
        }
        return $this->repository->find($id);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }

    public function findPairs($criteria, $value = NULL, $orderBy = array(), $key = NULL)
    {
        return $this->repository->findPairs($criteria, $value, $orderBy, $key);
    }

    public function findBy(array $criteria, array $order = null, $limit = null, $offset = null)
    {
        return $this->repository->findBy($criteria, $order, $limit, $offset);
    }

    public function findOneBy($array)
    {
        return $this->repository->findOneBy($array);
    }



}
