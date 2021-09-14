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

global $PAGE;

require_once ($CFG->dirroot.'/course/moodleform_mod.php');

class mod_edulabbtn_mod_form extends moodleform_mod {
    function definition() {

        $mform = $this->_form;

        //-------------------------------------------------------
        $mform->addElement('header', 'general', get_string('general', 'form'));

        $mform->addElement('text', 'name', get_string('name'), array('size'=>'48'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');


        $radioarray = array();
        $radioarray[] = $mform->createElement('radio', 'edu_url_option', null, get_string("form:course_shortname", "edulabbtn"), 'edu_course_shortname');
        $radioarray[] = $mform->createElement('radio', 'edu_url_option', null, get_string("form:labid", "edulabbtn"), 'edu_labid');
        $radioarray[] = $mform->createElement('radio', 'edu_url_option', null, get_string("form:url", "edulabbtn"), 'edu_url');
        $mform->addGroup($radioarray, 'edu_url_option', get_string("form:edu_url_option", "edulabbtn"), ' ', false);
        $mform->setDefault('edu_url_option', '');


        $mform->addElement('text', 'lab_id', get_string('lab_id', 'edulabbtn'), array('size'=>'9'), ['disabled' => true]);
        $mform->setType('lab_id', PARAM_TEXT);
        $mform->hideif('lab_id', 'edu_url_option', 'neq', 'edu_labid');
        $mform->disabledIf('lab_id', 'edu_url_option', 'neq', 'edu_labid');
        $this->standard_intro_elements();

        //-------------------------------------------------------
        $this->standard_coursemodule_elements();

        //-------------------------------------------------------
        $this->add_action_buttons();
    }


    public function validation($data, $files) {
        $errors = parent::validation($data, $files);
        if ($data['edu_url_option'] == "edu_labid" && !$data['lab_id']) {
            $errors['lab_id'] = get_string('required');
            return $errors;
        }
        return $errors;
    }
}
