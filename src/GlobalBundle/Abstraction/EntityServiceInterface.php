<?php

namespace GlobalBundle\Abstraction;

interface EntityServiceInterface
{
    /**
     * Get all entities.
     */
    public function getAll();

    /**
     * Get an entity with the given id.
     *
     * @param int $id The entity id to retrieve.
     */
    public function get($id, $fullObject=true);

    /**
     * Get an entity with the given id and throws an HTTPNotFound error if it doesn't exists.
     *
     * @param int $id The entity id to retrieve.
     */
    public function getOr404($id, $fullObject=true);

    /**
     * Saves and entity without passing by form.
     *
     * @param $entity
     */
    public function save($entity);

    /**
     * Post an entity form, creates a new entity.
     *
     * @param array $parameters Post entity parameters.
     */
    public function post(array $parameters);

    /**
     * Modify an existing entity or create a new one if entity is null.
     *
     * @param $id The entity id to retrieve.
     * @param array $parameters Post entity parameters.
     */
    public function put($id, array $parameters);

    /**
     * Patch an existing entity.
     *
     * @param $id The entity id to retrieve.
     * @param array $parameters Post entity parameters.
     */
    public function patch($id, array $parameters);

    /**
     * Delete an existing entity.
     *
     * @param $id The entity id to delete.
     */
    public function delete($id);
}