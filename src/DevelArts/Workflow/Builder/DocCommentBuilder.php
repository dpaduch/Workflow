<?php

namespace DevelArts\Workflow\Builder;

use DevelArts\Workflow;

/**
 * Workflow builder based on class comments
 *
 * @author Dariusz Paduch <dariusz.paduch@gmail.com>
 */
class DocCommentBuilder implements BuilderInterface
{
    /**
     * @var \Develarts\Workflow\WorkflowEntityInterface
     */
    protected $entity;

    /**
     * @var \Develarts\Workflow\WorkflowFactory
     */
    protected $factory;

    /**
     * @param \Develarts\Workflow\WorkflowEntityInterface $entity
     */
    public function __construct(Workflow\WorkflowEntityInterface $entity)
    {
        $this->entity = $entity;
    }

    /* (non-PHPdoc)
     * @see \DevelArts\Workflow\Builder\BuilderInterface::build()
     */
    public function build(Workflow\WorkflowFactory $factory)
    {
        $this->factory = $factory;

        $refClass = new \ReflectionClass($this->entity);
        $comment = $refClass->getDocComment();

        $this->buildStates($comment);
        $this->buildActions($comment);
    }

    /**
     * Creates states objects.
     *
     * @param string $comment Data
     */
    protected function buildStates($comment)
    {
        if (!preg_match_all('/@WF\\\\state (([^\@]*) \@ )?(.*)/', $comment, $tags, PREG_SET_ORDER)) {
            return;
        }

        $workflow = $this->factory->getWorkflow();
        foreach ($tags as $tag) {
            $name = defined($tag[3]) ? constant($tag[3]) : $tag[3];
            $this->factory->addState($name, $tag[2]);
        }
    }

    /**
     * Creates actions.
     *
     * @param string $comment Data
     *
     * @throws \InvalidArgumentException
     */
    protected function buildActions($comment)
    {
        $pattern = '/@WF\\\\action (([^\@]*) \@ )?(([a-zA-Z\/]*)\:\:)?([a-zA-Z]*) > (.*)/';
        if (!preg_match_all($pattern, $comment, $tags, PREG_SET_ORDER)) {
            return;
        }

        $workflow = $this->factory->getWorkflow();
        foreach ($tags as $tag) {
            $stateName = defined($tag[6]) ? constant($tag[6]) : $tag[6];
            if (!($state = $workflow->getState($stateName))) {
                throw new \InvalidArgumentException('invalid state specified');
            }
            $action = $this->factory->createAction($tag[5], $state);
            $action->setLabel($tag[2]);
            if ($tag[4]) {
                $this->configureAction($action, $tag[4]);
            } else {
                foreach ($workflow->getStates() as $state) {
                    $state->addAction($action);
                }
            }
        }
    }

    /**
     * Configure action with mediator.
     *
     * @param Workflow\WorkflowAction $action   Workflow action to configure
     * @param string                  $mediator Mediator class name
     *
     * @return \Workflow\WorkflowAction
     */
    protected function configureAction(Workflow\WorkflowAction $action, $mediator)
    {
        $workflow = $this->factory->getWorkflow();

        $refClass = new \ReflectionClass($mediator);
        $comment = $refClass->getDocComment();

        $this->buildActionStates($action, $comment);
        $this->buildActionConstraints($action, $comment);
        $this->buildActionObservers($action, $comment);

        return $action;
    }

    /**
     * Creates states for action.
     *
     * @param Workflow\WorkflowAction $action  Workflow action to build states
     * @param string                  $comment Data
     */
    protected function buildActionStates(Workflow\WorkflowAction $action, $comment)
    {
        $workflow = $this->factory->getWorkflow();

        if (!preg_match_all('/@WF\\\\ifstate (.*)/', $comment, $tags, PREG_SET_ORDER)) {
            // add all possible states if not configured
            foreach ($workflow->getStates() as $state) {
                $state->addAction($action);
            }
            return;
        }

        foreach ($tags as $tag) {
            $stateName = defined($tag[1]) ? constant($tag[1]) : $tag[1];
            if (($state = $workflow->getState($stateName))) {
                $state->addAction($action);
            }
        }
    }

    /**
     * Creates constraints for action.
     *
     * @param Workflow\WorkflowAction $action  Workflow action to build constraints
     * @param string                  $comment Data
     */
    protected function buildActionConstraints(Workflow\WorkflowAction $action, $comment)
    {
        if (!preg_match_all('/@WF\\\\constraint ([a-zA-Z\/]*)/', $comment, $tags, PREG_SET_ORDER)) {
            return;
        }
        foreach ($tags as $tag) {
            $constraint = $this->createConstraint($tag[1]);
            $action->addConstraint($constraint);
        }
    }

    /**
     * Creates observers for action.
     *
     * @param Workflow\WorkflowAction $action  Workflow action to build constraints
     * @param string                  $comment Data
     */
    protected function buildActionObservers(Workflow\WorkflowAction $action, $comment)
    {
        if (!preg_match_all('/@WF\\\\observer ([a-zA-Z\/]*)/', $comment, $tags, PREG_SET_ORDER)) {
            return;
        }
        foreach ($tags as $tag) {
            $observer = $this->createObserver($tag[1]);
            $action->addObserver($observer);
        }
    }

    /**
     * Creates constraint class by name.
     *
     * @param string $class Name of class
     *
     * @return Workflow\WorkflowConstraintInterface
     */
    protected function createConstraint($class)
    {
        $constraint = new $class;
        return $constraint;
    }

    /**
     * Creates observer class by name.
     *
     * @param string $class Name of class
     *
     * @return Workflow\WorkflowObserverInterface
     */
    protected function createObserver($class)
    {
        $observer = new $class;
        return $observer;
    }
}
