<?php

namespace DevelArts\Workflow;

require_once 'TestModel/TestWorkflowEntity.php';
require_once 'TestModel/TestWorkflowObserver.php';
require_once 'TestModel/TestWorkflowConstraint.php';

class WorkflowActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var WorkflowAction
     */
    private $action;

    public function setUp()
    {
        $this->action = new WorkflowAction('testAction', new WorkflowState('testState'));
    }

    public function testName()
    {
        $this->assertEquals('testAction', $this->action->getName());
    }

    public function testLabel()
    {
        $label = 'testLabel';
        $action = clone $this->action;
        $action->setLabel($label);
        $this->assertEquals($label, $action->getLabel());
    }

    public function testObserver()
    {
        $observer = new TestModel\TestWorkflowObserver();
        $entity = new TestModel\TestWorkflowEntity();

        $action = clone $this->action;
        $action->addObserver($observer);
        $action->process($entity);

        $this->assertTrue($observer->before);
        $this->assertTrue($observer->after);
    }

    public function testConstraint()
    {
        $constraint = new TestModel\TestWorkflowConstraint();
        $entity = new TestModel\TestWorkflowEntity();

        $action = clone $this->action;
        $action->addConstraint($constraint);

        $action->process($entity);
        $this->assertFalse($action->checkConstraints($entity));

        $entity->setName('testEntity');
        $this->assertTrue($action->checkConstraints($entity));
    }
}