<?php

// config for ChrisReedIO/AzureGraph
return [
    'pagination' => [
        'limit' => 500,
    ],
    'cache' => [
        'enabled' => true,
        'ttl' => 60 * 60 * 24,

        'keys' => [
            'deltas' => [
                'users' => 'azure-graph.deltas.users',
                // 'groups' => 'azure-graph.deltas.groups',
                // 'roles' => 'azure-graph.deltas.roles',
                // 'permissions' => 'azure-graph.deltas.permissions',
            ],
        ],
    ]
];
