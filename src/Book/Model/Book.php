<?php
namespace Book\Model;

use Book\Entity\Book as BookEntity;
use Meezaan\MicroServiceHelper\EntityBuilder;

class Book
{
    private $entityBuilder;
    private $entityManager;
    private $errors;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->entityBuilder = new EntityBuilder($this->entityManager, new BookEntity());
    }
    
    public function post($data)
    {
        if ($this->entityBuilder->isValid($data)) {
            $id = $this->entityBuilder->save($data);

            return $id;
        }

        $this->errors = $this->entityBuilder->getValidationErrors();

        return false;
    }


    public function validate($data)
    {
        return $this->entityBuilder->validate($data);
    }

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

    public function get($id)
    {
        // Load Entity
        $entity = $this->entityManager->find('\Book\Entity\Book', (int) $id);

        // Update Entity Builder
        $this->entityBuilder->setEntity($entity);
        return $this->entityBuilder->get($id);
            
    }


    public function getErrors()
    {
        return $this->errors;
    }

}
