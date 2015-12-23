<?php

namespace DevelArts\Workflow;

require_once 'Model/TestWorkflowEntity.php';
require_once 'Model/TestWorkflowConstraint.php';
require_once 'Model/TestWorkflowObserver.php';

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
        $observer = new TestWorkflowObserver();
        $entity = new TestWorkflowEntity();

        $action = clone $this->action;
        $action->addObserver($observer);
        $action->process($entity);

        $this->assertTrue($observer->before);
        $this->assertTrue($observer->after);
    }

    public function testConstraint()
    {
        $constraint = new TestWorkflowConstraint();
        $entity = new TestWorkflowEntity();

        $action = clone $this->action;
        $action->addConstraint($constraint);

        $action->process($entity);
        $this->assertFalse($action->checkConstraints($entity));

        $entity->setName('testEntity');
        $this->assertTrue($action->checkConstraints($entity));
    }
}