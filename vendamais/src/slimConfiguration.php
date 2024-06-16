<?php

namespace src;

function slimConfiguration(): \Slim\Container
{
    $configuration = [
        'settings' => [
            'displayErrorDetails' => getenv('DISPLAY_ERRORS_DETAILS'),
            'determineRouteBeforeAppMiddleware' => true,
        ],
    ];
    return new \Slim\Container($configuration);
}