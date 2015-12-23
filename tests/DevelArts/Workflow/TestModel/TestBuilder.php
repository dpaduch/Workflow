<?php

namespace DevelArts\Workflow\TestModel;

use DevelArts\Workflow;

class TestBuilder implements Workflow\Builder\BuilderInterface
{
    protected $builded = false;

    public function build(Workflow\WorkflowFactory $factory)
    {
        $this->builded = true;
    }

    public function isBuilded()
    {
        return $this->builded === true;
    }
}
