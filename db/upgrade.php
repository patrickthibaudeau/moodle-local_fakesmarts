<?php
defined('MOODLE_INTERNAL') || die();

function xmldb_local_fakesmarts_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2023072701) {

        // Define table local_fakesmarts to be created.
        $table = new xmldb_table('local_fakesmarts');

        // Adding fields to table local_fakesmarts.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('description', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('bot_type', XMLDB_TYPE_INTEGER, '2', null, null, null, '1');
        $table->add_field('bot_system_message', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('usermodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table local_fakesmarts.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('usermodified', XMLDB_KEY_FOREIGN, ['usermodified'], 'user', ['id']);

        // Conditionally launch create table for local_fakesmarts.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Define table local_fakesmarts_files to be created.
        $table = new xmldb_table('local_fakesmarts_files');

        // Adding fields to table local_fakesmarts_files.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('fakesmarts_id', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('content', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('usermodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table local_fakesmarts_files.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('usermodified', XMLDB_KEY_FOREIGN, ['usermodified'], 'user', ['id']);

        // Conditionally launch create table for local_fakesmarts_files.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023072701, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023072702) {

        // Define table local_fakesmarts_permission to be created.
        $table = new xmldb_table('local_fakesmarts_permission');

        // Adding fields to table local_fakesmarts_permission.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('fakesmarts_id', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('user_id', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('role', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('usermodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table local_fakesmarts_permission.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('usermodified', XMLDB_KEY_FOREIGN, ['usermodified'], 'user', ['id']);

        // Conditionally launch create table for local_fakesmarts_permission.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023072702, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023072801) {

        // Define table local_fakesmarts_type to be created.
        $table = new xmldb_table('local_fakesmarts_type');

        // Adding fields to table local_fakesmarts_type.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('system_message', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('usermodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table local_fakesmarts_type.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('usermodified', XMLDB_KEY_FOREIGN, ['usermodified'], 'user', ['id']);

        // Conditionally launch create table for local_fakesmarts_type.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023072801, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023073000) {

        // Define table local_fakesmarts_logs to be created.
        $table = new xmldb_table('local_fakesmarts_logs');

        // Adding fields to table local_fakesmarts_logs.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('fakesmarts_id', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('prompt', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('message', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('confidence', XMLDB_TYPE_INTEGER, '3', null, null, null, '0');
        $table->add_field('ip', XMLDB_TYPE_CHAR, '15', null, null, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '16', null, null, null, '0');

        // Adding keys to table local_fakesmarts_logs.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for local_fakesmarts_logs.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023073000, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023073004) {

        // Define table local_fakesmarts_qa to be created.
        $table = new xmldb_table('local_fakesmarts_qa');

        // Adding fields to table local_fakesmarts_qa.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('fakesmarts_id', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('question', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('answer', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('accuracy', XMLDB_TYPE_INTEGER, '1', null, null, null, '0');
        $table->add_field('usermodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table local_fakesmarts_qa.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('usermodified', XMLDB_KEY_FOREIGN, ['usermodified'], 'user', ['id']);

        // Conditionally launch create table for local_fakesmarts_qa.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023073004, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023080401) {

        // Define table local_fakesmarts_logs to be dropped.
        $table = new xmldb_table('local_fakesmarts_logs');

        // Conditionally launch drop table for local_fakesmarts_logs.
        if ($dbman->table_exists($table)) {
            $dbman->drop_table($table);
        }

        // Define table local_fakesmarts_logs to be created.
        $table = new xmldb_table('local_fakesmarts_logs');

        // Adding fields to table local_fakesmarts_logs.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('fakesmarts_id', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, null, null, '0');
        $table->add_field('prompt', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('message', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('confidence', XMLDB_TYPE_INTEGER, '3', null, null, null, '0');
        $table->add_field('prompt_tokens', XMLDB_TYPE_INTEGER, '20', null, null, null, '0');
        $table->add_field('completion_tokens', XMLDB_TYPE_INTEGER, '20', null, null, null, '0');
        $table->add_field('total_tokens', XMLDB_TYPE_INTEGER, '20', null, null, null, '0');
        $table->add_field('cost', XMLDB_TYPE_NUMBER, '12, 6', null, null, null, '0.0');
        $table->add_field('ip', XMLDB_TYPE_CHAR, '15', null, null, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '16', null, null, null, '0');

        // Adding keys to table local_fakesmarts_logs.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);

        // Conditionally launch create table for local_fakesmarts_logs.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023080401, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023080505) {

        // Define field use_indexing_server to be added to local_fakesmarts_type.
        $table = new xmldb_table('local_fakesmarts_type');
        $field = new xmldb_field('use_indexing_server', XMLDB_TYPE_INTEGER, '1', null, null, null, '1', 'system_message');

        // Conditionally launch add field use_indexing_server.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023080505, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023080506) {

        // Define field description to be added to local_fakesmarts_type.
        $table = new xmldb_table('local_fakesmarts_type');
        $field = new xmldb_field('description', XMLDB_TYPE_TEXT, null, null, null, null, null, 'name');

        // Conditionally launch add field description.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023080506, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023081500) {

        // Define field welcome_message to be added to local_fakesmarts.
        $table = new xmldb_table('local_fakesmarts');
        $field = new xmldb_field('welcome_message', XMLDB_TYPE_TEXT, null, null, null, null, null, 'bot_type');

        // Conditionally launch add field welcome_message.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023081500, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023082300) {

        // Define table local_fakesmarts_models to be created.
        $table = new xmldb_table('local_fakesmarts_models');

        // Adding fields to table local_fakesmarts_models.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('azure_endpoint', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('azure_key', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('azure_deployment_name', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('prompt_cost', XMLDB_TYPE_NUMBER, '8, 4', null, null, null, '0');
        $table->add_field('completion_cost', XMLDB_TYPE_NUMBER, '8, 4', null, null, null, '0');
        $table->add_field('usermodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table local_fakesmarts_models.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('usermodified', XMLDB_KEY_FOREIGN, ['usermodified'], 'user', ['id']);

        // Conditionally launch create table for local_fakesmarts_models.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023082300, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023082301) {

        // Define field model_name to be added to local_fakesmarts_models.
        $table = new xmldb_table('local_fakesmarts_models');
        $field = new xmldb_field('model_name', XMLDB_TYPE_CHAR, '50', null, null, null, 'gpt-35-turbo-16k', 'azure_deployment_name');

        // Conditionally launch add field model_name.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023082301, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023082302) {

        // Define field model_id to be added to local_fakesmarts_type.
        $table = new xmldb_table('local_fakesmarts_type');
        $field = new xmldb_field('model_id', XMLDB_TYPE_INTEGER, '10', null, null, null, '0', 'id');

        // Conditionally launch add field model_id.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023082302, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023082500) {

        // Define field indexing_server_url to be added to local_fakesmarts_models.
        $table = new xmldb_table('local_fakesmarts_models');
        $field = new xmldb_field('indexing_server_url', XMLDB_TYPE_CHAR, '255', null, null, null, null, 'model_name');

        // Conditionally launch add field indexing_server_url.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field indexing_server_key to be added to local_fakesmarts_models.
        $table = new xmldb_table('local_fakesmarts_models');
        $field = new xmldb_field('indexing_server_key', XMLDB_TYPE_CHAR, '1333', null, null, null, null, 'indexing_server_url');

        // Conditionally launch add field indexing_server_key.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023082500, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023082600) {

        // Define table local_fakesmarts_models to be dropped.
        $table = new xmldb_table('local_fakesmarts_models');

        // Conditionally launch drop table for local_fakesmarts_models.
        if ($dbman->table_exists($table)) {
            $dbman->drop_table($table);
        }

        // Define table local_fakesmarts_models to be created.
        $table = new xmldb_table('local_fakesmarts_models');

        // Adding fields to table local_fakesmarts_models.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('azure_endpoint', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('azure_api_version', XMLDB_TYPE_CHAR, '50', null, null, null, null);
        $table->add_field('azure_key', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('azure_deployment_name', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('model_name', XMLDB_TYPE_CHAR, '50', null, null, null, 'gpt-35-turbo-16k');
        $table->add_field('prompt_cost', XMLDB_TYPE_NUMBER, '8, 4', null, null, null, '0');
        $table->add_field('completion_cost', XMLDB_TYPE_NUMBER, '8, 4', null, null, null, '0');
        $table->add_field('usermodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table local_fakesmarts_models.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, ['id']);
        $table->add_key('usermodified', XMLDB_KEY_FOREIGN, ['usermodified'], 'user', ['id']);

        // Conditionally launch create table for local_fakesmarts_models.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023082600, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023082605) {

        // Define field model_id to be dropped from local_fakesmarts_type.
        $table = new xmldb_table('local_fakesmarts_type');
        $field = new xmldb_field('model_id');

        // Conditionally launch drop field model_id.
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        // Define field model_id to be added to local_fakesmarts.
        $table = new xmldb_table('local_fakesmarts');
        $field = new xmldb_field('model_id', XMLDB_TYPE_INTEGER, '10', null, null, null, '0', 'id');

        // Conditionally launch add field model_id.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023082605, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023082606) {

        // Define field embedding_id to be added to local_fakesmarts.
        $table = new xmldb_table('local_fakesmarts');
        $field = new xmldb_field('embedding_id', XMLDB_TYPE_INTEGER, '10', null, null, null, '0', 'model_id');

        // Conditionally launch add field embedding_id.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023082606, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023082700) {

        // Define field context to be added to local_fakesmarts_logs.
        $table = new xmldb_table('local_fakesmarts_logs');
        $field = new xmldb_field('context', XMLDB_TYPE_TEXT, null, null, null, null, null, 'message');

        // Conditionally launch add field context.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023082700, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023082701) {

        // Rename field context on table local_fakesmarts_logs to index_context.
        $table = new xmldb_table('local_fakesmarts_logs');
        $field = new xmldb_field('context', XMLDB_TYPE_TEXT, null, null, null, null, null, 'message');

        // Launch rename field context.
        $dbman->rename_field($table, $field, 'index_context');

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023082701, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023082800) {

        // Define field is_embedding to be added to local_fakesmarts_models.
        $table = new xmldb_table('local_fakesmarts_models');
        $field = new xmldb_field('is_embedding', XMLDB_TYPE_INTEGER, '1', null, null, null, '0', 'azure_deployment_name');

        // Conditionally launch add field is_embedding.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023082800, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023090400) {

        // Define field system_reserved to be added to local_fakesmarts.
        $table = new xmldb_table('local_fakesmarts');
        $field = new xmldb_field('system_reserved', XMLDB_TYPE_INTEGER, '1', null, null, null, '0', 'embedding_id');

        // Conditionally launch add field system_reserved.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023090400, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023090501) {

        // Rename field use_indexing_server on table local_fakesmarts_type to NEWNAMEGOESHERE.
        $table = new xmldb_table('local_fakesmarts_type');
        $field = new xmldb_field('use_indexing_server', XMLDB_TYPE_INTEGER, '1', null, null, null, '1', 'system_message');

        // Launch rename field use_indexing_server.
        $dbman->rename_field($table, $field, 'use_bot_server');

        // Define field publlic to be added to local_fakesmarts.
        $table = new xmldb_table('local_fakesmarts');
        $field = new xmldb_field('publlic', XMLDB_TYPE_INTEGER, '1', null, null, null, '0', 'description');

        // Conditionally launch add field publlic.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field requires_user_prompt to be added to local_fakesmarts.
        $table = new xmldb_table('local_fakesmarts');
        $field = new xmldb_field('requires_user_prompt', XMLDB_TYPE_INTEGER, '1', null, null, null, '1', 'bot_type');

        // Conditionally launch add field requires_user_prompt.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define field user_prompt to be added to local_fakesmarts.
        $table = new xmldb_table('local_fakesmarts');
        $field = new xmldb_field('user_prompt', XMLDB_TYPE_TEXT, null, null, null, null, null, 'requires_user_prompt');

        // Conditionally launch add field user_prompt.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023090501, 'local', 'fakesmarts');
    }

    if ($oldversion < 2023090503) {

        // Rename field publlic on table local_fakesmarts to NEWNAMEGOESHERE.
        $table = new xmldb_table('local_fakesmarts');
        $field = new xmldb_field('publlic', XMLDB_TYPE_INTEGER, '1', null, null, null, '0', 'description');

        // Launch rename field publlic.
        $dbman->rename_field($table, $field, 'publish');

        // Fakesmarts savepoint reached.
        upgrade_plugin_savepoint(true, 2023090503, 'local', 'fakesmarts');
    }

    return true;
}