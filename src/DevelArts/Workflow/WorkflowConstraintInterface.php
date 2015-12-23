<?php

namespace DevelArts\Workflow;

interface WorkflowConstraintInterface
{
    /**
     * @param WorkflowEntityInterface $entity
     * @return bool
     */
    public function check(WorkflowEntityInterface $entity);
}
