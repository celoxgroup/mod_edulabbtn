<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * Plugin version and other meta-data are defined here.
 *
 * @package     mod_edulabbtn
 * @copyright   2021 celoxgroup <jerry.stefik@celoxgroup.com.au>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    require_once("$CFG->libdir/resourcelib.php");

    $auth_methods = [
        'local'     => get_string('auth_method:local', 'edulabbtn'),
        'google'    => get_string('auth_method:google', 'edulabbtn'),
        'microsoft' => get_string('auth_method:microsoft', 'edulabbtn')
    ];

    //--- general settings -----------------------------------------------------------------------------------
    $settings->add(new admin_setting_configtext('edulabbtn/tenant_id',
        get_string('tenant_id', 'edulabbtn'),
        get_string('tenant_id:desc', 'edulabbtn'),
        null,
        PARAM_TEXT)
    );

    $settings->add(new admin_setting_configselect('edulabbtn/auth_method',
        get_string('auth_method', 'edulabbtn'), '', 'local', $auth_methods));
}
