<?php
namespace Book\Model;

use Book\Entity\Book as BookEntity;
use Meezaan\MicroServiceHelper\EntityBuilder;

/**
 * [Book description]
 */
class Book
{
    /**
     * [private description]
     *
     * @var [type]
     */
    private $entityBuilder;

    /**
     * [private description]
     *
     * @var [type]
     */
    private $entityManager;

    /**
     * [private description]
     *
     * @var [type]
     */
    private $errors;


    /**
     * [__construct description]
     *
     * @param DoctrineORMEntityManager $entityManager [description]
     */
    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->entityBuilder = new EntityBuilder($this->entityManager, new BookEntity());
    }

    /**
     * [post description]
     *
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function post($data)
    {
        if ($this->entityBuilder->isValid($data)) {
            $id = $this->entityBuilder->save($data);

            return $id;
        }

        $this->errors = $this->entityBuilder->getValidationErrors();

        return false;
    }

    /**
     * [validate description]
     *
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function validate($data)
    {
        return $this->entityBuilder->validate($data);
    }

    /**
     * [put description]
     *
     * @param  [type] $data [description]
     * @param  [type] $id   [description]
     * @return [type]       [description]
     */
    public function put($data, $id)
    {
        // Load Entity
        $entity = $this->entityManager->find('\Book\Entity\Book', (int) $id);

        // Update Entity Builder
        $this->entityBuilder->setEntity($entity);
        if (isset($data['id'])) {
            unset($data['id']);
        }
        if ($this->entityBuilder->isValid($data)) {
            $id = $this->entityBuilder->save($data);

            return $id;
        }

        $this->errors = $this->entityBuilder->getValidationErrors();

        return false;

    }

    /**
     * [get description]
     *
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function get($id = null)
    {
        if ($id !== null) {
            // Load Entity
            $entity = $this->entityManager->find('\Book\Entity\Book', (int) $id);

            // Update Entity Builder
            $this->entityBuilder->setEntity($entity);

            return $this->entityBuilder->get($id);
        }

        $result = [];
        $entities = $this->entityManager->getRepository('\Book\Entity\Book')->findAll();
        foreach($entities as $entity) {
            $this->entityBuilder->setEntity($entity);
            $result[] = $this->entityBuilder->get($entity->getId());
        }

        return $result;


    }

    /**
     * [getErrors description]
     *
     * @return [type] [description]
     */
    public function getErrors()
    {
        return $this->errors;
    }

}
