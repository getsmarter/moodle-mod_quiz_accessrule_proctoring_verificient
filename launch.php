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
//
// This file is part of BasicLTI4Moodle
//
// BasicLTI4Moodle is an IMS BasicLTI (Basic Learning Tools for Interoperability)
// consumer for Moodle 1.9 and Moodle 2.0. BasicLTI is a IMS Standard that allows web
// based learning tools to be easily integrated in LMS as native ones. The IMS BasicLTI
// specification is part of the IMS standard Common Cartridge 1.1 Sakai and other main LMS
// are already supporting or going to support BasicLTI. This project Implements the consumer
// for Moodle. Moodle is a Free Open source Learning Management System by Martin Dougiamas.
// BasicLTI4Moodle is a project iniciated and leaded by Ludo(Marc Alier) and Jordi Piguillem
// at the GESSI research group at UPC.
// SimpleLTI consumer for Moodle is an implementation of the early specification of LTI
// by Charles Severance (Dr Chuck) htp://dr-chuck.com , developed by Jordi Piguillem in a
// Google Summer of Code 2008 project co-mentored by Charles Severance and Marc Alier.
//
// BasicLTI4Moodle is copyright 2009 by Marc Alier Forment, Jordi Piguillem and Nikolas Galanis
// of the Universitat Politecnica de Catalunya http://www.upc.edu
// Contact info: Marc Alier Forment granludo @ gmail.com or marc.alier @ upc.edu

/**
 * This file contains all necessary code to view a lti activity instance
 *
 * @package    mod
 * @subpackage lti
 * @copyright  2009 Marc Alier, Jordi Piguillem, Nikolas Galanis
 *  marc.alier@upc.edu
 * @copyright  2009 Universitat Politecnica de Catalunya http://www.upc.edu
 * @author     Marc Alier
 * @author     Jordi Piguillem
 * @author     Nikolas Galanis
 * @author     Chris Scribner
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("../../../../config.php");
require_once($CFG->dirroot.'/mod/lti/lib.php');
require_once($CFG->dirroot.'/mod/lti/locallib.php');
global $DB, $PAGE, $SESSION,$CFG;
if(isset($_GET['qid'])) {
    $q_id = required_param('qid', PARAM_INT); // Quiz ID
}
$course_id = required_param('cid', PARAM_INT); // Course Module ID

$quiz_array = $DB->get_records('quiz',array('id' => $q_id));
$quiz_array_key = array_keys($quiz_array);
$quiz_object = $quiz_array[$quiz_array_key[0]];
$passcode = $quiz_object->password;
$quiz_type_module_id = $DB->get_field('modules', 'id', array('name' => 'quiz'));
$cm_id = $DB->get_field('course_modules', 'id', array('module'=> $quiz_type_module_id, 'instance'=>$q_id));
$cm_obj = $DB->get_record('course_modules', array('module'=> $quiz_type_module_id, 'instance'=>$q_id));
$course_name = $DB->get_field('course', 'shortname', array('id'=>$course_id));
$course_obj = $DB->get_record('course', array('id'=>$course_id));
$callback_url = $CFG->wwwroot . '/mod/quiz/startattempt.php' . '?sesskey=' . $USER->sesskey . '&cmid=' . $cm_id . '&verificient_return=1';
$qname = $quiz_object->name;
$SESSION->proctoringtoolurl = $CFG->quizaccess_proctoring_verificient_toolurl;
$lti = new stdClass;

$lti->id=$q_id;
$lti->course=$course_id;
$lti->name=$CFG->quizaccess_proctoring_verificient_name;
$lti->intro='';
$lti->introformat=1;
$lti->timecreated=time();//
$lti->timemodified=time();//
$lti->typeid=0;
$lti->toolurl=$CFG->quizaccess_proctoring_verificient_toolurl;
$lti->securetoolurl='';
$lti->instructorchoicesendname='1';
$lti->instructorchoicesendemailaddr='1';
$lti->instructorchoiceallowroster='';
$lti->instructorchoiceallowsetting='';
$lti->instructorchoiceacceptgrades=1;
$lti->grade=100.00000;
$lti->launchcontainer=1;//
$lti->resourcekey=$CFG->quizaccess_proctoring_verificient_resokey;
$lti->password=$CFG->quizaccess_proctoring_verificient_password;
$lti->debuglaunch=0;
$lti->showtitlelaunch=0;
$lti->showdescriptionlaunch=0;
$lti->servicesalt='';//
$lti->instructorcustomparameters='institution_id='. $CFG->quizaccess_proctoring_verificient_institid ."\npasscode=". $passcode . "\nquiz_name=" . $qname . "\ncallback_url=" . $callback_url . "\ncourse_name=" . $course_name;
$lti->icon='';
$lti->secureicon='';
$lti->cmid = $cm_id;

$context = context_module::instance($cm_id);
require_login($course_obj, true, $cm_obj); //setup page context https://docs.moodle.org/dev/Page_API

if (intval($CFG->branch) >= 30) {
    lti_view($lti, $course_obj, $cm_obj, $context);
    lti_launch_tool($lti);
} else {
    lti_view($lti);
}
