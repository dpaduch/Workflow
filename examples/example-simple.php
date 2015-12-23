<?php

require_once 'bootstrap.php';

use DevelArts\Workflow;

$factory = new Workflow\WorkflowFactory;

// define states
$factory->addStates([
    OrderStatusEnum::PLACED => 'Placed',
    OrderStatusEnum::PROCESSING => 'Processing',
    OrderStatusEnum::SENT => 'Sent',
    OrderStatusEnum::COMPLETED  => 'Completed',
    OrderStatusEnum::CANCELED => 'Canceled'
]);

$workflow = $factory->getWorkflow();

// create action "Process"
$action = $factory->createAction('process', $workflow->getState(OrderStatusEnum::PROCESSING), new OrderProcessAction());
$action->setLabel('Process');
$action->addConstraint(new OrderProcessingConstraint);

// add process to states
$workflow->getState(OrderStatusEnum::PLACED)->addAction($action);
$workflow->getState(OrderStatusEnum::CANCELED)->addAction($action);

// create action "Cancel"
$action = $factory->createAction('cancel', $workflow->getState(OrderStatusEnum::CANCELED));
$action->addObserver(new OrderCancelReasonObserver);
$action->setLabel('Cancel');

// add cancel to states
$workflow->getState(OrderStatusEnum::PLACED)->addAction($action);
$workflow->getState(OrderStatusEnum::PROCESSING)->addAction($action);

// create action "Send"
$action = $factory->createAction('send', $workflow->getState(OrderStatusEnum::SENT));
$action->setLabel('Send');

// add send to states
$workflow->getState(OrderStatusEnum::PROCESSING)->addAction($action);

// create "Complete" action
$action = $factory->createAction('complete', $workflow->getState(OrderStatusEnum::COMPLETED));
$action->setLabel('Complete');

// add complete to states
$workflow->getState(OrderStatusEnum::SENT)->addAction($action);

// prepare entity
$order = new Order;
$order->setState($workflow->getState(OrderStatusEnum::PLACED));

Example::run($workflow, $order);
