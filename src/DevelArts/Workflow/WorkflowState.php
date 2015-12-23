<?php

namespace DevelArts\Workflow;

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
     * @param string $name
     * @param string $label
     */
    public function __construct($name, $label = null)
    {
        $this->name = (string)$name;
        $this->label = $label ?: $this->generateLabel($name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getLabel();
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @param WorkflowAction $action
     */
    public function addAction(WorkflowAction $action)
    {
        $this->actions[$action->getName()] = $action;
    }

    /**
     * @param string $name
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
     * @return WorkflowAction[]
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @param string $name
     * @return string
     */
    protected function generateLabel($name)
    {
        return ucfirst($name);
    }
}
