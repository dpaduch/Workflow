<?php

namespace DevelArts\Workflow\TestModel;

use DevelArts\Workflow;

class TestWorkflowObserver implements Workflow\WorkflowObserverInterface
{
    public $before = false;

    public $after = false;

    public function before(Workflow\WorkflowEntityInterface $entity)
    {
        $this->before = true;
    }

    public function after(Workflow\WorkflowEntityInterface $entity)
    {
        $this->after = true;
    }
}