<?php

namespace DevelArts\Workflow;

interface WorkflowExecutorInterface
{
    /**
     * @param WorkflowEntityInterface $entity
     * @return bool
     */
    public function execute(WorkflowEntityInterface $entity);
}
