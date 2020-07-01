<?php

defined('MOODLE_INTERNAL') || die();

    $settings = new admin_settingpage('modsettingsquizcatproctoring_verificient', get_string('pluginname', 'quizaccess_proctoring_verificient'));
    $settings->add(new admin_setting_heading('quizaccess_proctoring_verificient_settings', '',
       get_string('settingdesc', 'quizaccess_proctoring_verificient')));
    $settings->add(new admin_setting_heading('quizaccess_proctoring_verificient_basicsettings',
        get_string('basicsettings', 'quizaccess_proctoring_verificient'), ''));
    $settings->add(new admin_setting_configtext('quizaccess_proctoring_verificient_name',
        get_string('name','quizaccess_proctoring_verificient'), '', ''));
    $settings->add(new admin_setting_configtext('quizaccess_proctoring_verificient_toolurl',
        get_string('toolurl','quizaccess_proctoring_verificient'), '', ''));
    $settings->add(new admin_setting_configtext('quizaccess_proctoring_verificient_resokey',
        get_string('resokey','quizaccess_proctoring_verificient'), '', ''));
    $settings->add(new admin_setting_configtext('quizaccess_proctoring_verificient_password',
        get_string('password','quizaccess_proctoring_verificient'), '', ''));
    $settings->add(new admin_setting_configtext('quizaccess_proctoring_verificient_institid',
        get_string('institute','quizaccess_proctoring_verificient'), '', ''));
