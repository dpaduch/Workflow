<?php

namespace DevelArts\Workflow;

/**
 * Workflow state class.
 *
 * @author Dariusz Paduch <dariusz.paduch@gmail.com>
 */
class WorkflowState
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var WorkflowAction[]
     */
    protected $actions = [];

    /**
     * @param string $name  Name of state
     * @param string $label Label of state
     */
    public function __construct($name, $label = null)
    {
        $this->name = (string)$name;
        $this->label = $label ?: $this->generateLabel($name);
    }

    /**
     * Returns name of state.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns label of state.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getLabel();
    }

    /**
     * Returns label of state.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Sets label of state.
     *
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Adds action for state.
     *
     * @param WorkflowAction $action
     */
    public function addAction(WorkflowAction $action)
    {
        $this->actions[$action->getName()] = $action;
    }

    /**
     * Returns action by name.
     *
     * @param string $name
     *
     * @return NULL|WorkflowAction
     */
    public function getAction($name)
    {
        if (isset($this->actions[$name])) {
            return $this->actions[$name];
        }
        return null;
    }

    /**
     * Returns array of actions allowed for this state
     *
     * @return WorkflowAction[]
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Generates state label by name
     *
     * @param string $name
     *
     * @return string
     */
    protected function generateLabel($name)
    {
        return ucfirst($name);
    }
}
