<?php

namespace DevelArts\Workflow;

/**
 * Workflow action class to handle the action execution
 *
 * @author Dariusz Paduch <dariusz.paduch@gmail.com>
 */
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
     * @var WorkflowMediatorInterface
     */
    protected $mediator;

    /**
     * @var WorkflowConstraintInterface[]
     */
    protected $constraints = [];

    /**
     * @var WorkflowConstraintInterface[]
     */
    protected $observers = [];

    /**
     * @param string                    $name     Name of the action
     * @param WorkflowState             $state    Final state of the action
     * @param WorkflowMediatorInterface $mediator Mediator of the action
     */
    public function __construct($name, WorkflowState $state, WorkflowMediatorInterface $mediator = null)
    {
        $this->name = $name;
        $this->state = $state;
        $this->mediator = $mediator;
    }

    /**
     * Returns name of the action.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns label of the action.
     *
     * ... or name if label not specified.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label ?: $this->getName();
    }

    /**
     * Sets label of the action.
     *
     * @param string $label Label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Adds constraint to the action.
     *
     * @param WorkflowConstraintInterface $constraint Constraint to add
     */
    public function addConstraint(WorkflowConstraintInterface $constraint)
    {
        $this->constraints[] = $constraint;
    }

    /**
     * Adds observer to action.
     *
     * @param WorkflowObserverInterface $observer Observer to add
     */
    public function addObserver(WorkflowObserverInterface $observer)
    {
        $this->observers[] = $observer;
    }

    /**
     * Process action.
     *
     * @param WorkflowEntityInterface $entity Entity to process
     */
    public function process(WorkflowEntityInterface $entity)
    {
        if (!$this->checkConstraints($entity)) {
            return false;
        }

        $this->notify('before', $entity);

        if (!$this->mediator || $this->mediator->execute($entity) !== false) {
            $entity->setState($this->state);
        }

        $this->notify('after', $entity);

        return true;
    }

    /**
     * Check constraints for entity.
     *
     * @param WorkflowEntityInterface $entity Entity to check
     *
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
     * Notify observers about event.
     *
     * @param string                  $event  Event name
     * @param WorkflowEntityInterface $entity Processing entity
     */
    protected function notify($event, WorkflowEntityInterface $entity)
    {
        foreach ($this->observers as $observer) {
            $observer->$event($entity);
        }
    }
}
