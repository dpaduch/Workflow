<?php

namespace DevelArts\Workflow;

/**
 * Interface of action mediator.
 *
 * @author Dariusz Paduch <dariusz.paduch@gmail.com>
 */
interface WorkflowMediatorInterface
{
    /**
     * Execute action.
     *
     * @param WorkflowEntityInterface $entity Entity to execute
     *
     * @return bool true if success
     */
    public function execute(WorkflowEntityInterface $entity);
}
