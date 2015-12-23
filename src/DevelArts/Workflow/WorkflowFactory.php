<?php

namespace DevelArts\Workflow;

class WorkflowFactory
{
    /**
     * @var Workflow
     */
    protected $workflow;

    public static function build(Builder\BuilderInterface $builder)
    {
        $factory = new self();
        $builder->build($factory);

        return $factory->getWorkflow();
    }

    /**
     * @param Workflow $workflow
     */
    public function __construct(Workflow $workflow = null)
    {
        $this->workflow = $workflow ?: new Workflow();
    }

    /**
     * @return Workflow
     */
    public function getWorkflow()
    {
        return $this->workflow;
    }

    /**
     * @param array $states
     */
    public function addStates(array $states)
    {
        foreach ($states as $name => $label) {
            $this->addState($name, $label);
        }
    }

    /**
     * @param string $name
     * @param string $label
     * @return WorkflowState
     */
    public function addState($name, $label = null)
    {
        $state = new WorkflowState($name, $label);
        $this->workflow->addState($state);

        return $state;
    }

    /**
     * @param string $name
     * @param WorkflowActionInterface $executor
     * @return WorkflowAction
     */
    public function createAction($name, WorkflowState $state, WorkflowExecutorInterface $executor = null)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('name of the action must be a string');
        }

        if (preg_match('/[^a-z_0-9]/i', $name)) {
            throw new \InvalidArgumentException('name of the action must be only A-Z, 0-9 or _');
        }

        $action = new WorkflowAction($name, $state, $executor);
        return $action;
    }
}
