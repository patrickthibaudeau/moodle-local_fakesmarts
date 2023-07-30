<?php
$functions = array(
    'fakesmarts_content_delete' => array(
        'classname' => 'local_fakesmarts_external_content',
        'methodname' => 'delete',
        'classpath' => 'local/fakesmarts/classes/external/content.php',
        'description' => 'Delete content',
        'type' => 'write',
        'capabilities' => '',
        'ajax' => true
    ),
    'fakesmarts_bot_delete' => array(
        'classname' => 'local_fakesmarts_external_bot',
        'methodname' => 'delete',
        'classpath' => 'local/fakesmarts/classes/external/bot.php',
        'description' => 'Delete bot',
        'type' => 'write',
        'capabilities' => '',
        'ajax' => true
    ),
    'fakesmarts_bot_type_delete' => array(
        'classname' => 'local_fakesmarts_external_bot_type',
        'methodname' => 'delete',
        'classpath' => 'local/fakesmarts/classes/external/bot_type.php',
        'description' => 'Delete bot type',
        'type' => 'write',
        'capabilities' => '',
        'ajax' => true
    ),
    'fakesmarts_get_gpt_response' => array(
        'classname' => 'local_fakesmarts_external_gpt',
        'methodname' => 'response',
        'classpath' => 'local/fakesmarts/classes/external/gpt.php',
        'description' => 'Returns response from OpenAI',
        'type' => 'read',
        'capabilities' => '',
        'ajax' => true
    ),
);