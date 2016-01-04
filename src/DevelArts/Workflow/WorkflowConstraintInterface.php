<?php

namespace DevelArts\Workflow;

/**
 * Interface of workflow constraints.
 *
 * @author Dariusz Paduch <dariusz.paduch@gmail.com>
 */
interface WorkflowConstraintInterface
{
    /**
     * Returns true or false if the constraint is not valid
     *
     * @param WorkflowEntityInterface $entity Entity to check
     *
     * @return bool
     */
    public function check(WorkflowEntityInterface $entity);
}
