<?php

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
