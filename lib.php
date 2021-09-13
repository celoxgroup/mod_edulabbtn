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

/**
 * Add edulabbtn instance.
 * @param object $data
 * @param object $mform
 * @return int new edulabbtn instance id
 */
function edulabbtn_add_instance($data, $mform) {
    global $DB;

    $data->timemodified = time();
    $data->id = $DB->insert_record('edulabbtn', $data);

    return $data->id;
}

/**
 * Update edulabbtn instance.
 * @param object $data
 * @param object $mform
 * @return bool true
 */
function edulabbtn_update_instance($data, $mform) {
    global $DB;

    $data->id           = $data->instance;
    $data->timemodified = time();

    $DB->update_record('edulabbtn', $data);

    return true;
}

/**
 * Delete edulabbtn instance.
 * @param int $id
 * @return bool true
 */
function edulabbtn_delete_instance($id) {
    global $DB;

    if (!$btn = $DB->get_record('edulabbtn', ['id' => $id])) {
        return false;
    }

    // note: all context files are deleted automatically
    $DB->delete_records('edulabbtn', ['id' => $btn->id]);
    return true;
}


function edulabbtn_get_coursemodule_info($coursemodule) {
    global $CFG, $DB;

    if (!$btn = $DB->get_record('edulabbtn', ['id' => $coursemodule->instance],
        'id, name, lab_id, intro, introformat')) {
        return NULL;
    }

    $info = new cached_cm_info();
    $info->name = $btn->name;

    $fullurl = "$CFG->wwwroot/mod/edulabbtn/view.php?id=$coursemodule->id";
    $info->onclick = "window.open('$fullurl','_blank'); return false;";

    if ($coursemodule->showdescription) {
        $info->content = format_module_intro('edulabbtn', $btn, $coursemodule->id, false);
    }

    return $info;
}
