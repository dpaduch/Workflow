<?php

namespace DevelArts\Workflow;

require_once 'TestModel/TestBuilder.php';

class WorkflowFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var WorkflowFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new WorkflowFactory();
    }

    public function testBuild()
    {
        $builder = new TestModel\TestBuilder;
        $workflow = WorkflowFactory::build($builder);
        $this->assertTrue($workflow instanceof Workflow);
        $this->assertTrue($builder->isBuilded());
    }

    public function testStates()
    {
        $factory = $this->factory;
        $workflow = $factory->getWorkflow();

        $name = 'test-state';
        $state = $factory->addState($name);

        $this->assertTrue($state instanceof WorkflowState);
        $this->assertTrue($state->getName() == $name);
        $this->assertNotEmpty($workflow->getState($name));

        $name = 'test-state-2';
        $factory->addStates(array($name => $name));
        $this->assertNotEmpty($workflow->getState($name));

        return $state;
    }

    /**
     * @depends testStates
     */
    public function testActions(WorkflowState $state)
    {
        $factory = $this->factory;
        $workflow = $factory->getWorkflow();

        $name = 'testAction';
        $action = $factory->createAction($name, $state);

        $this->assertNotEmpty($action instanceof WorkflowAction);
    }

    /**
     * @depends testStates
     * @expectedException \InvalidArgumentException
     */
    public function testActionNameNotString(WorkflowState $state)
    {
        $this->factory->createAction(1, $state);
    }

    /**
     * @depends testStates
     * @expectedException \InvalidArgumentException
     */
    public function testActionNameInvalid(WorkflowState $state)
    {
        $this->factory->createAction('invalid action name', $state);
    }
}
