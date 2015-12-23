<?php

namespace DevelArts\Workflow;

class TestWorkflowConstraint implements WorkflowConstraintInterface
{
    public function check(WorkflowEntityInterface $entity)
    {
        if ($entity->getName()) {
            return true;
        }
    }
}