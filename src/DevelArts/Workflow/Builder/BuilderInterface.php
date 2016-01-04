<?php

namespace DevelArts\Workflow\Builder;

use DevelArts\Workflow\WorkflowFactory;

/**
 * Interface of workflow builder
 *
 * @author Dariusz Paduch <dariusz.paduch@gmail.com>
 */
interface BuilderInterface
{
    /**
     * Builds the workflow using factory.
     *
     * @param WorkflowFactory $factory Factory to use
     */
    public function build(WorkflowFactory $factory);
}
