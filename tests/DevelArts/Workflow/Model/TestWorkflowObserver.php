<?php

namespace DevelArts\Workflow;

class TestWorkflowObserver implements WorkflowObserverInterface
{
    public $before = false;

    public $after = false;

    public function before(WorkflowEntityInterface $entity)
    {
        $this->before = true;
    }

    public function after(WorkflowEntityInterface $entity)
    {
        $this->after = true;
    }
}