<?php

namespace DevelArts\Workflow;

class WorkflowStateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var WorkflowState
     */
    private $state;

    /**
     * @var WorkflowAction
     */
    private $action;

    public function setUp()
    {
        $this->state = new WorkflowState('test-state');
        $this->action = new WorkflowAction('testAction', $this->state);
    }

    public function testName()
    {
        $this->assertEquals('test-state', (string)$this->state->getName());
    }

    public function testLabel()
    {
        $state = clone $this->state;
        $this->assertEquals('Test-state', (string)$state);

        $label = 'Test state 2';
        $state->setLabel($label);

        $this->assertEquals($label, (string)$state);
    }

    public function testAction()
    {
        $state = clone $this->state;
        $action = clone $this->action;
        $state->addAction($action);
        $this->assertNotEmpty($state->getAction($action->getName()));

        $actions = $state->getActions();
        $this->assertTrue(count($actions) == 1);
        $this->assertTrue(isset($actions['testAction']));
    }

    public function testUndefinedAction()
    {
        $this->assertTrue($this->state->getAction('undefined') === null);
    }
}
