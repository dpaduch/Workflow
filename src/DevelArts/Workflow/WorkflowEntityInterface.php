<?php

namespace DevelArts\Workflow;

interface WorkflowEntityInterface
{
    /**
     * @return WorkflowState
     */
    public function getState();

    /**
     * @param WorkflowState $state
     */
    public function setState(WorkflowState $state);
}
