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
 * Version information for the quiz_proctoring_verificient plugin.
 *
 * @package   quizaccess_proctoring_verificient
 * @copyright 2013 Verificent Inc
 * @license   
 * @author iank.it
 */


defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/mod/quiz/accessrule/accessrulebase.php');
require_once($CFG->dirroot.'/mod/lti/lib.php');
require_once($CFG->dirroot.'/mod/lti/locallib.php');
require_once($CFG->dirroot.'/mod/quiz/accessrule/proctoring_verificient/render.php');
global $PAGE;
$PAGE->requires->js("/mod/quiz/accessrule/proctoring_verificient/js/lti.js");
/**
 *
 * @copyright 2015 Verificent Inc
 */
class quizaccess_proctoring_verificient extends quiz_access_rule_base {

public function is_preflight_check_required($attemptid) {
    if (empty($attemptid)){
        return true;
    } else {
        global $SESSION;
        return empty($SESSION->passwordcheckedquizzes[$this->quiz->id]);
    }
}

public function add_preflight_check_form_fields(mod_quiz_preflight_check_form $quizform,
    MoodleQuickForm $mform, $attemptid) {

    $mform->addElement('header', 'proctoring_verificientheader',
        get_string('proctoring_verificientheader', 'quizaccess_proctoring_verificient'));
    $mform->addElement('static', 'proctoring_verificientmessage', '',
          "Quiz passcode will be made available after verification on verificient's platform");

    $html = $this->get_lti_html();
    $mform->addElement('static', 'proctoring_verificientlti', '',$html  );
    $mform->addElement('hidden', 'proctoring_verificient', '1', 'Verificient Verified');
    $mform->setType('proctoring_verificient', PARAM_RAW);
}  

/**
 * @return string the HTML for embedding verificient widnow 
 *      using lti
 */

private function get_lti_html() {
    global $DB,$PAGE,$CFG; 
    $lti = new stdClass();
    $lti->toolurl = $CFG->quizaccess_proctoring_verificient_toolurl;
    $lti->ltiversion = '';
    $tool = lti_get_tool_by_url_match($lti->toolurl);
    if ($tool) {
        $toolconfig = lti_get_type_config($tool->id);
    } else {
        $toolconfig = array();
    }

    $launchcontainer = lti_get_launch_container($lti, $toolconfig);


    $qid = $this->quiz->id;
    $cid = $this->quiz->course;
    $quiz_array = $DB->get_records('quiz',array('id' => $qid));
    $quiz_array_key = array_keys($quiz_array);
    $quiz_object = $quiz_array[$quiz_array_key[0]];
    $passcode = $quiz_object->password;
    if(empty($passcode)) {
        $passcode = substr(md5(rand()), 0, 6); //generate a random 6 letter string
        $quiz_object->password = $passcode;  //add this as passcode to quiz object
        $is_passcode_added = $DB->update_record('quiz', $quiz_object); //update in database
        if(!$is_passcode_added) {
            error_log('Some error in adding passcode to the quiz');
        }
    } 
    $html   = htmlobjectdata($qid,$cid);
    $verifi = optional_param('verificient_return', 0, PARAM_INT);
    if($verifi == 1) {
        global $SESSION;
        $SESSION->mytestcheck = $verifi;
        $html .= $PAGE->requires->js_init_call('proctoringhidelti');
   }else {
	$html = htmlframedata($qid,$cid);
    global $SESSION;
    $currentfilename = basename($_SERVER['PHP_SELF']);
    if($currentfilename!='startattempt.php'){
        @$SESSION->mytestcheck = 0;
        @$SESSION->verifi_cmid = optional_param('id',  0, PARAM_INT);
    }
    if(($currentfilename=='startattempt.php') && (@$SESSION->mytestcheck!=1)){
        global $USER,$CFG;
        $redirurl = $CFG->wwwroot."/mod/quiz/view.php?id=".@$SESSION->verifi_cmid;
        redirect($redirurl);
    }
    
    $html .=$PAGE->requires->js_init_call("proctoringlti",array($currentfilename));
	}
    return $html;
}

public function validate_preflight_check($data, $files, $errors, $attemptid) {
    if (empty($data['proctoring_verificient'])) {
        $errors['proctoring_verificient'] = get_string('youmustagree', 'quizaccess_proctoring_verificient');
    }

    return $errors;
}

public static function make(quiz $quizobj, $timenow, $canignoretimelimits) {

    if (empty($quizobj->get_quiz()->proctoringrequired)) {
        return null;
    }
    
    return new self($quizobj, $timenow);
}

public static function add_settings_form_fields(
    mod_quiz_mod_form $quizform, MoodleQuickForm $mform) {
    $mform->addElement('checkbox', 'proctoringrequired',
        get_string('proctoringrequired', 'quizaccess_proctoring_verificient'), '' );
    $mform->addHelpButton('proctoringrequired',
        'proctoringrequired', 'quizaccess_proctoring_verificient');
}

public static function save_settings($quiz) {
    global $DB;
    if (empty($quiz->proctoringrequired)) {
        $DB->delete_records('quizaccess_verificient', array('quizid' => $quiz->id));
    } else {
        if (!$DB->record_exists('quizaccess_verificient', array('quizid' => $quiz->id))) {
            $record = new stdClass();
            $record->quizid = $quiz->id;
            $record->proctoringrequired = 1;
            $DB->insert_record('quizaccess_verificient', $record);
        }
    }
}

public static function get_settings_sql($quizid) {
    return array(
        'proctoringrequired',
        'LEFT JOIN {quizaccess_verificient} proctoring_verificient ON proctoring_verificient.quizid = quiz.id',
        array());
}

public function current_attempt_finished() {
    global $SESSION;
}

public function setup_attempt_page($page) {
        #
}

}
