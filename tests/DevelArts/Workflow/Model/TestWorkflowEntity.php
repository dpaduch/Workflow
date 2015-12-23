<?php

namespace DevelArts\Workflow;

class TestWorkflowEntity implements WorkflowEntityInterface
{
    private $state;

    private $name;

    public function setState(WorkflowState $state)
    {
        $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}