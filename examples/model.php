<?php

use DevelArts\Workflow;

class Example
{
    const QUIT_KEY = 'q';

    public static function run($workflow, $entity)
    {
        do {

            if (isset($option)) {
                $i = 1;
                foreach ($state->getActions() as $action) {
                    if (!$action->checkConstraints($entity)) {
                        continue;
                    }
                    if ($i++ != $option) {
                        continue;
                    }
                    $workflow->{$action->getName()}($entity);
                }
                echo "\n";
            }

            $state = $entity->getState();
            echo "=== " . get_class($entity) . ': ' . $state->getLabel() . "\n\n";

            $i = 1;

            foreach ($state->getActions() as $action) {
                if ($action->checkConstraints($entity)) {
                    echo ' ' . $i++ . '. ' . $action->getLabel() . "\n";
                }
            }

            echo ' ' . self::QUIT_KEY . '. Exit' . "\n\n";

            echo 'What to do? ';

        } while (($option = readline()) != self::QUIT_KEY);
    }
}

class OrderStatusEnum
{
    const PLACED = 1;
    const PROCESSING = 2;
    const SENT = 3;
    const CANCELED = 4;
    const COMPLETED = 5;
}

/**
 * @WF\state Placed @ OrderStatusEnum::PLACED
 * @WF\state Processing @ OrderStatusEnum::PROCESSING
 * @WF\state Sent @ OrderStatusEnum::SENT
 * @WF\state Completed @ OrderStatusEnum::COMPLETED
 * @WF\state Canceled @ OrderStatusEnum::CANCELED
 *
 * @WF\action Process @ OrderProcessAction::process > OrderStatusEnum::PROCESSING
 * @WF\action Cancel @ OrderCancelAction::cancel > OrderStatusEnum::CANCELED
 * @WF\action Send @ OrderSendAction::send > OrderStatusEnum::SENT
 * @WF\action Complete @ OrderCompleteAction::complete > OrderStatusEnum::COMPLETED
 */
class Order implements Workflow\WorkflowEntityInterface
{
    private $state;

    private $reason;

    public function getState()
    {
        return $this->state;
    }

    public function setState(Workflow\WorkflowState $state)
    {
        $this->state = $state;
    }

    public function setCancelReason($reason)
    {
        $this->reason = $reason;
    }
}

/**
 * @WF\ifstate OrderStatusEnum::PLACED
 * @WF\ifstate OrderStatusEnum::CANCELED
 * @WF\constraint OrderProcessingConstraint
 */
class OrderProcessAction implements Workflow\WorkflowMediatorInterface
{
    public function execute(Workflow\WorkflowEntityInterface $entity)
    {
        echo "Processing order...\n";
    }
}

class OrderProcessingConstraint implements Workflow\WorkflowConstraintInterface
{
    public function check(Workflow\WorkflowEntityInterface $entity)
    {
        // do not process order on sunday
        return date('W') != 0;
    }
}

/**
 * @WF\ifstate OrderStatusEnum::PLACED
 * @WF\ifstate OrderStatusEnum::PROCESSING
 * @WF\observer OrderCancelReasonObserver
 */
class OrderCancelAction implements Workflow\WorkflowMediatorInterface
{
    public function execute(Workflow\WorkflowEntityInterface $entity)
    {
        echo "Canncelling order...\n";
    }
}

class OrderCancelReasonObserver implements Workflow\WorkflowObserverInterface
{
    public function before(Workflow\WorkflowEntityInterface $entity)
    {}

    public function after(Workflow\WorkflowEntityInterface $entity)
    {
        echo 'Please enter the reason of cancellation: ';
        $entity->setCancelReason(readline());
        echo "Thanks!\n";
    }
}

/**
 * @WF\ifstate OrderStatusEnum::PROCESSING
 */
class OrderSendAction implements Workflow\WorkflowMediatorInterface
{
    public function execute(Workflow\WorkflowEntityInterface $entity)
    {
        echo "Sending order...\n";
    }
}

/**
 * @WF\ifstate OrderStatusEnum::SENT
 */
class OrderCompleteAction implements Workflow\WorkflowMediatorInterface
{
    public function execute(Workflow\WorkflowEntityInterface $entity)
    {
        echo "Completing order...\n";
    }
}
