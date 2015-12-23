<?php

namespace DevelArts\Workflow;

class Workflow
{
    /**
     * @var WorkflowState[]
     */
    protected $states = [];

    /**
     * @param string $method
     * @param array $args
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
     * @param WorkflowState $state
     * @return \DevelArts\Workflow\Workflow
     */
    public function addState(WorkflowState $state)
    {
        $this->states[$state->getName()] = $state;
        return $this;
    }

    /**
     * @param string $name
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
     * @return WorkflowState[]
     */
    public function getStates()
    {
        return $this->states;
    }
}
