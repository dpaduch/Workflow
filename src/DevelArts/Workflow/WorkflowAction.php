<?php

namespace DevelArts\Workflow;

class WorkflowAction
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
     * @var WorkflowState
     */
    protected $state;

    /**
     * @var WorkflowExecutorInterface
     */
    protected $executor;

    /**
     * @var WorkflowConstraintInterface[]
     */
    protected $constraints = [];

    /**
     * @var WorkflowConstraintInterface[]
     */
    protected $observers = [];

    /**
     * @param WorkflowState $state
     * @param WorkflowExecutorInterface $executor
     */
    public function __construct($name, WorkflowState $state, WorkflowExecutorInterface $executor = null)
    {
        $this->name = $name;
        $this->state = $state;
        $this->executor = $executor;
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
    public function getLabel()
    {
        return $this->label ?: $this->getName();
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @param WorkflowConstraintInterface $constraint
     */
    public function addConstraint(WorkflowConstraintInterface $constraint)
    {
        $this->constraints[] = $constraint;
    }

    /**
     * @param WorkflowObserverInterface $observer
     */
    public function addObserver(WorkflowObserverInterface $observer)
    {
        $this->observers[] = $observer;
    }

    /**
     * @param WorkflowEntityInterface $entity
     */
    public function process(WorkflowEntityInterface $entity)
    {
        if (!$this->checkConstraints($entity)) {
            return false;
        }

        $this->notify('before', $entity);

        if (!$this->executor || $this->executor->execute($entity) !== false) {
            $entity->setState($this->state);
        }

        $this->notify('after', $entity);

        return true;
    }

    /**
     * @param WorkflowEntityInterface $entity
     * @return boolean
     */
    public function checkConstraints(WorkflowEntityInterface $entity)
    {
        foreach ($this->constraints as $constraint) {
            if (!$constraint->check($entity)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param string $event
     * @param WorkflowEntityInterface $entity
     */
    protected  function notify($event, WorkflowEntityInterface $entity)
    {
        foreach ($this->observers as $observer) {
            $observer->$event($entity);
        }
    }
}
