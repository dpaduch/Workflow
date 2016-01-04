<?php

namespace DevelArts\Workflow;

/**
 * Interface of workflow entity.
 *
 * @author Dariusz Paduch <dariusz.paduch@gmail.com>
 */
interface WorkflowEntityInterface
{
    /**
     * Returns workflow state.
     *
     * @return WorkflowState
     */
    public function getState();

    /**
     * Sets workflow state.
     *
     * @param WorkflowState $state
     */
    public function setState(WorkflowState $state);
}
