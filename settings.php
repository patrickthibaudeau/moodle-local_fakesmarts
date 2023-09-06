<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin administration pages are defined here.
 *
 * @package     local_aiquestions
 * @category    admin
 * @copyright   2023 Ruthy Salomon <ruthy.salomon@gmail.com> , Yedidia Klein <yedidia@openapp.co.il>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_fakesmarts_settings', new lang_string('pluginname', 'local_fakesmarts'));

    // Max chunks
    $settings->add( new admin_setting_configtext(
        'local_fakesmarts/max_chunks',
        get_string('chunk_limit', 'local_fakesmarts'),
        get_string('chunk_limit_help', 'local_fakesmarts'),
        65000, PARAM_INT, 6
    ));

    //Bot Server
    $settings->add( new admin_setting_configtext(
        'local_fakesmarts/bot_server_url',
        get_string('bot_server_url', 'local_fakesmarts'),
        get_string('bot_server_url_help', 'local_fakesmarts'),
        '', PARAM_TEXT, 255
    ));

    $settings->add( new admin_setting_configpasswordunmask(
        'local_fakesmarts/bot_server_api_key',
        get_string('bot_server_api_key', 'local_fakesmarts'),
        get_string('bot_server_api_key_help', 'local_fakesmarts'),
        '', PARAM_TEXT, 255
    ));

    //Embedding Server
    $settings->add( new admin_setting_configtext(
        'local_fakesmarts/embedding_server_url',
        get_string('embedding_server_url', 'local_fakesmarts'),
        get_string('embedding_server_url_help', 'local_fakesmarts'),
        '', PARAM_TEXT, 255
    ));

    // Indexing Server
    $settings->add( new admin_setting_configtext(
        'local_fakesmarts/indexing_server_url',
        get_string('indexing_server_url', 'local_fakesmarts'),
        get_string('indexing_server_url_help', 'local_fakesmarts'),
        '', PARAM_TEXT, 255
    ));

    $settings->add( new admin_setting_configpasswordunmask(
        'local_fakesmarts/indexing_server_api_key',
        get_string('indexing_server_api_key', 'local_fakesmarts'),
        get_string('indexing_server_api_key_help', 'local_fakesmarts'),
        '', PARAM_TEXT, 255
    ));

    // MinutesMaster id
    $settings->add( new admin_setting_configtext(
        'local_fakesmarts/minutes_master',
        get_string('minutes_master_id', 'local_fakesmarts'),
        get_string('minutes_master_id_help', 'local_fakesmarts'),
        '', PARAM_INT, 10
    ));

    $ADMIN->add('localplugins', $settings);

    // phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedIf
    if ($ADMIN->fulltree) {
        // TODO: Define actual plugin settings page and add it to the tree - {@link https://docs.moodle.org/dev/Admin_settings}.
    }
}
