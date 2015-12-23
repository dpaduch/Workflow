<?php

namespace DevelArts\Workflow;

use DevelArts\Workflow\WorkflowFactory;

class TestBuilder implements Builder\BuilderInterface
{
    protected $builded = false;

    public function build(WorkflowFactory $factory)
    {
        $this->builded = true;
    }

    public function isBuilded()
    {
        return $this->builded === true;
    }
}
