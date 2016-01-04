<?php

namespace DevelArts\Workflow;

/**
 * Interface of action observer.
 *
 * @author Dariusz Paduch <dariusz.paduch@gmail.com>
 */
interface WorkflowObserverInterface
{
    /**
     * Trigger before action.
     *
     * @param WorkflowEntityInterface $entity Processed entity
     *
     * @return bool If false then stop the workflow process
     */
    public function before(WorkflowEntityInterface $entity);

    /**
     * Trigger after action.
     *
     * @param WorkflowEntityInterface $entity Processed entity
     */
    public function after(WorkflowEntityInterface $entity);
}
