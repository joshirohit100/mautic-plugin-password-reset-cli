<?php

return [
    'name'        => 'Mautic Password Reset',
    'description' => 'Reset mautic user password from the command line.',
    'version'     => '1.0.0',
    'author'      => 'Rohit Joshi',
    'services'    => [
        'commands' => [
            'mautic.user.command.password_reset' => [
                'class'     => \MauticPlugin\PasswordResetBundle\Command\PasswordResetCommand::class,
                'arguments' => [
                    'security.password_encoder',
                    'mautic.model.factory'
                ],
                'tag' => 'console.command',
            ],
        ],
    ],
];