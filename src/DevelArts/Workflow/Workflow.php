<?php

namespace DevelArts\Workflow;

/**
 * Worklfow class
 *
 * @author Dariusz Paduch <dariusz.paduch@gmail.com>
 */
class Workflow
{
    /**
     * @var WorkflowState[]
     */
    protected $states = [];

    /**
     * Process workflow.
     *
     * @param string $method Method to call
     * @param array $args Arguments for call
     *
     * @throws \InvalidArgumentException
     */
    public function __call($method, array $args = null)
    {
        if (!isset($args[0]) || !$args[0] instanceof WorkflowEntityInterface) {
            throw new \InvalidArgumentException(sprintf('invalid entity specified'));
        }

        $entity = $args[0];

        if (!($state = $entity->getState())) {
            throw new \InvalidArgumentException('entity have no state');
        }

        if (!($action = $state->getAction($method))) {
            throw new \InvalidArgumentException(sprintf('invalid action specified: %s', $method));
        }

        return $action->process($args[0]);
    }

    /**
     * Adds new workflow state.
     *
     * @param WorkflowState $state State object to add
     *
     * @return \DevelArts\Workflow\Workflow
     */
    public function addState(WorkflowState $state)
    {
        $this->states[$state->getName()] = $state;
        return $this;
    }

    /**
     * Returns workflow state object by name.
     *
     * @param string $name Name of requested state
     *
     * @return WorkflowState
     */
    public function getState($name)
    {
        if (isset($this->states[$name])) {
            return $this->states[$name];
        }
        return null;
    }

    /**
     * Returns array of workflow states.
     *
     * @return WorkflowState[]
     */
    public function getStates()
    {
        return $this->states;
    }
}
