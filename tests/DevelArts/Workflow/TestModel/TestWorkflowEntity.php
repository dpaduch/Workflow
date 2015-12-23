<?php

namespace DevelArts\Workflow\TestModel;

use DevelArts\Workflow;

/**
 * @WF\state TestState1 @ test-state-1
 * @WF\state TestState2 @ test-state-2
 */
class TestWorkflowEntity implements Workflow\WorkflowEntityInterface
{
    private $state;

    private $name;

    public function setState(Workflow\WorkflowState $state)
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