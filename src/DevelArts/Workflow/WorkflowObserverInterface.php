<?php

namespace DevelArts\Workflow;

interface WorkflowObserverInterface
{
    /**
     * @param WorkflowEntityInterface $entity
     * @return bool
     */
    public function before(WorkflowEntityInterface $entity);

    /**
     * @param WorkflowEntityInterface $entity
     */
    public function after(WorkflowEntityInterface $entity);
}
