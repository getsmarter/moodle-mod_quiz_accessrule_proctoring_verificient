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
/**
 * Privacy Subsystem implementation for quizaccess_proctoring_verificient.
 *
 * @package    quizaccess_proctoring_verificient
 * @copyright  2020 verificient soluction
 */
namespace quizaccess_proctoring_verificient\privacy;
defined('MOODLE_INTERNAL') || die();
/**
 * Privacy Subsystem for quizaccess_proctoring_verificient implementing null_provider.
 *
 * @copyright  2020 verificient soluction
 */
class provider implements \core_privacy\local\metadata\null_provider {
    /**
     * Get the language string identifier with the component's language
     * file to explain why this plugin stores no data.
     *
     * @return  string
     */
    public static function get_reason() : string {
        return 'privacy:metadata';
    }
}
