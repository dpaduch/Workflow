<?php

namespace DevelArts\Workflow;

require_once 'Model/TestWorkflowEntity.php';

class WorkflowTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Workflow
     */
    private $workflow;

    /**
     * @var string
     */
    private $stateName;

    /**
     * @var WorkflowState
     */
    private $state;

    /**
     * @var string
     */
    private $actionName;

    /**
     * @var WorkflowAction
     */
    private $action;

    public function setUp()
    {
        $this->workflow = new Workflow();

        $this->stateName = 'test-state';
        $this->state = new WorkflowState($this->stateName);

        $this->actionName = 'test';
        $this->action = new WorkflowAction($this->actionName, $this->state);
    }

    public function testStates()
    {
        $state = clone $this->state;
        $workflow = clone $this->workflow;

        $workflow->addState($state);
        $this->assertTrue($workflow->getState($this->stateName) instanceof WorkflowState);

        $states = $workflow->getStates();
        $this->assertTrue(count($states) == 1);
        $this->assertTrue(isset($states[$this->stateName]));
    }

    public function testUndefinedState()
    {
        $this->assertTrue($this->workflow->getState('undefined') === null);
    }

    public function testCall()
    {
        $workflow = clone $this->workflow;

        $state = clone $this->state;
        $state->addAction($this->action);

        $entity = new TestWorkflowEntity();
        $entity->setState($state);

        $result = $workflow->{$this->actionName}($entity);
        $this->assertTrue($result);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUndefinedEntity()
    {
        $workflow = clone $this->workflow;
        $workflow->{$this->actionName}();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEntityState()
    {
        $workflow = clone $this->workflow;

        $entity = new TestWorkflowEntity();
        $workflow->{$this->actionName}($entity);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testUndefinedAction()
    {
        $workflow = clone $this->workflow;

        $entity = new TestWorkflowEntity();
        $entity->setState(clone $this->state);

        $workflow->undefined($entity);
    }
}
