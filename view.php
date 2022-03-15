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

require('../../config.php');
require_once("$CFG->dirroot/mod/edulabbtn/lib.php");
require_once($CFG->libdir . '/completionlib.php');

$id       = optional_param('id', 0, PARAM_INT);        // Course module ID
$u        = optional_param('u', 0, PARAM_INT);         // eduLAB instance id

if ($u) {  // Two ways to specify the module
    $edulabbtn = $DB->get_record('edulabbtn', array('id'=>$u), '*', MUST_EXIST);
    $cm = get_coursemodule_from_instance('edulabbtn', $edulabbtn->id, $edulabbtn->course, false, MUST_EXIST);

} else {
    $cm = get_coursemodule_from_id('edulabbtn', $id, 0, false, MUST_EXIST);
    $edulabbtn = $DB->get_record('edulabbtn', array('id'=>$cm->instance), '*', MUST_EXIST);
}

$course = $DB->get_record('course', array('id'=>$cm->course), '*', MUST_EXIST);

require_course_login($course, false, $cm);
$context = context_module::instance($cm->id);
require_capability('mod/edulabbtn:view', $context);



$url = "https://{tenant_id}.portal.edulab.cloud/app/edulab/labs/go/{lab_id}";
$eduUrlOptions = !empty($edulabbtn->edu_url_option) ? $edulabbtn->edu_url_option : "";
switch ($eduUrlOptions) {
  case "edu_course_shortname":
    $url = $url.  $course->shortname;
    break;
  case "edu_labid":
    $url = $url. $edulabbtn->lab_id;
    break;
  case "edu_url":
    $url;
    break;
}
$redirectTo = "{$url}?username={user}&auth={auth_method}";
$config = get_config('edulabbtn');
$redirectTo = str_replace(
    ['{tenant_id}', '{auth_method}', '{user}'],
    [$config->tenant_id, $config->auth_method, $USER->username],
    $redirectTo
);
@header('Location: '.$redirectTo);
