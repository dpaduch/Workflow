<?php

error_reporting(E_ALL);
chdir(__DIR__);

require_once '../vendor/autoload.php';
require_once 'model.php';

function dd($var)
{
    echo new Exception . "\n" . print_r($var, true) . "\n";
    exit;
}

function run($workflow, $order)
{
    do {

        if (isset($option)) {
            $i = 1;
            foreach ($state->getActions() as $action) {
                if ($i++ != $option) {
                    continue;
                }
                echo "\n"; // . ' * Action: ' . $action->getLabel() . "\n";
                $workflow->{$action->getName()}($order);
            }
            echo "\n";
        }

        $state = $order->getState();
        echo "=== " . 'Order: ' . $state->getLabel() . "\n\n";

        $i = 1;

        foreach ($state->getActions() as $action) {
            if ($action->checkConstraints($order)) {
                echo ' ' . $i++ . '. ' . $action->getLabel() . "\n";
            }
        }

        echo ' q. Exit' . "\n\n";

        echo 'What to do? ';

    } while (($option = readline()) != 'q');
}