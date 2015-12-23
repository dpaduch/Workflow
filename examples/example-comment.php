<?php

require_once 'bootstrap.php';

use DevelArts\Workflow;

$order = new Order;
$builder = new Workflow\Builder\DocCommentBuilder($order);
$workflow = Workflow\WorkflowFactory::create($builder);
$order->setState($workflow->getState(OrderStatusEnum::PLACED));

Example::run($workflow, $order);
