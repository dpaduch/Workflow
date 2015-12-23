<?php

namespace DevelArts\Workflow\Builder;

use DevelArts\Workflow;

require_once __DIR__ . '/../TestModel/TestWorkflowEntity.php';

class DocCommentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Workflow
     */
    private $workflow;

    public function setUp()
    {
        $entity = new Workflow\TestModel\TestWorkflowEntity;
        $this->workflow = Workflow\WorkflowFactory::build(new Workflow\Builder\DocCommentBuilder($entity));
    }

    public function testStates()
    {
        $state = $this->workflow->getState('test-state-1');
        $this->assertTrue($state instanceof Workflow\WorkflowState);
        $this->assertEquals('test-state-1', $state->getName());
    }
}
