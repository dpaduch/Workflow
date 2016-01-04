<?php

namespace DevelArts\Workflow;

/**
 * Factory of the workflow
 *
 * @author Dariusz Paduch <dariusz.paduch@gmail.com>
 */
class WorkflowFactory
{
    /**
     * @var Workflow
     */
    protected $workflow;

    /**
     * Builds the workflow.
     *
     * @param Builder\BuilderInterface $builder
     *
     * @return \DevelArts\Workflow\Workflow
     */
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
     * Returns builded workflow.
     *
     * @return Workflow
     */
    public function getWorkflow()
    {
        return $this->workflow;
    }

    /**
     * Adds array of states.
     *
     * @param array $states
     */
    public function addStates(array $states)
    {
        foreach ($states as $name => $label) {
            $this->addState($name, $label);
        }
    }

    /**
     * Adds state.
     *
     * @param string $name  Name of the state
     * @param string $label Label of the state
     *
     * @return WorkflowState
     */
    public function addState($name, $label = null)
    {
        $state = new WorkflowState($name, $label);
        $this->workflow->addState($state);

        return $state;
    }

    /**
     * Creates new action in workflow.
     *
     * @param string                    $name     Name of new action
     * @param WorkflowMediatorInterface $mediator Mediator class
     *
     * @return WorkflowAction
     */
    public function createAction($name, WorkflowState $state, WorkflowMediatorInterface $mediator = null)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('name of the action must be a string');
        }

        if (preg_match('/[^a-z_0-9]/i', $name)) {
            throw new \InvalidArgumentException('name of the action must be only A-Z, 0-9 or _');
        }

        $action = new WorkflowAction($name, $state, $mediator);
        return $action;
    }
}
