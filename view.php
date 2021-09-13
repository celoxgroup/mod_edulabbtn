<?php

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

$redirectTo = 'https://{tenant_id}.portal.edulab.cloud/go/{lab_id}?username={user}&auth={auth_method}';

$config = get_config('edulabbtn');

$redirectTo = str_replace(
    ['{tenant_id}', '{auth_method}', '{lab_id}', '{user}'],
    [$config->tenant_id, $config->auth_method,  $edulabbtn->lab_id, $USER->username],
    $redirectTo
);
@header('Location: '.$redirectTo);
