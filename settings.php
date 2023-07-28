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

    // Microsoft Azure Endpoint.
    $settings->add( new admin_setting_configtext(
        'local_fakesmarts/azure_endpoint',
        get_string('azure_endpoint', 'local_fakesmarts'),
        get_string('azure_endpoint_help', 'local_fakesmarts'),
        '', PARAM_TEXT, 255
    ));

    // Number of tries.
    $settings->add( new admin_setting_configpasswordunmask(
        'local_fakesmarts/azure_key',
        get_string('azure_key', 'local_fakesmarts'),
        get_string('azure_key_help', 'local_fakesmarts'),
        '', PARAM_TEXT, 255
    ));

    // Deployement name.
    $settings->add( new admin_setting_configtext(
        'local_fakesmarts/deployment_name',
        get_string('deployment_name', 'local_fakesmarts'),
        get_string('deployment_name_help', 'local_fakesmarts'),
        '', PARAM_TEXT, 255
    ));

    // MS OpenAI URL will be the following: $AZURE_ENDPOINT/openai/deployments/$DEPLOYMENT_NAME/chat/completions?api-version=2023-05-15

    $ADMIN->add('localplugins', $settings);

    // phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedIf
    if ($ADMIN->fulltree) {
        // TODO: Define actual plugin settings page and add it to the tree - {@link https://docs.moodle.org/dev/Admin_settings}.
    }
}
