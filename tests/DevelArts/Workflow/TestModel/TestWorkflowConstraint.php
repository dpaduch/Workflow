<?php

namespace DevelArts\Workflow\TestModel;

use DevelArts\Workflow;

class TestWorkflowConstraint implements Workflow\WorkflowConstraintInterface
{
    public function check(Workflow\WorkflowEntityInterface $entity)
    {
        if ($entity->getName()) {
            return true;
        }
    }
}