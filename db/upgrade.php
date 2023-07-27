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


    return true;
}