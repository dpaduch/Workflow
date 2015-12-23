<?php

namespace DevelArts\Workflow\Builder;

use DevelArts\Workflow\WorkflowFactory;

interface BuilderInterface
{
    public function build(WorkflowFactory $factory);
}
