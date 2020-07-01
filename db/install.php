<?php
defined('MOODLE_INTERNAL') || die;

function xmldb_quizaccess_proctoring_verificient_install() {
    global $CFG, $OUTPUT, $DB;
    $dbman = $DB->get_manager();
    
    $record1                 = new stdClass();
    $record1->name           = "quizaccess_proctoring_verificient_toolurl";
    $record1->value          = '';

    $record2                 = new stdClass();
    $record2->name           = "quizaccess_proctoring_verificient_resokey";
    $record2->value          = '';

    $record3                 = new stdClass();
    $record3->name           = "quizaccess_proctoring_verificient_password";
    $record3->value          = '';

    $record4                 = new stdClass();
    $record4->name           = "quizaccess_proctoring_verificient_institid";
    $record4->value          = '';

    $record5                 = new stdClass();
    $record5->name           = "quizaccess_proctoring_verificient_name";
    $record5->value          = '';
    
    if ($dbman->table_exists('config')) {
        $DB->insert_record('config', $record1);
        $DB->insert_record('config', $record2);
        $DB->insert_record('config', $record3);
        $DB->insert_record('config', $record4);
        $DB->insert_record('config', $record5);
    }
}
