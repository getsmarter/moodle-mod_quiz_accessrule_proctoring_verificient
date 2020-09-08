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
 * Version information for the quizaccess_proctoring_verificient plugin.
 *
 * @package   quizaccess_proctoring_verificient
 * @copyright 2013 Verificent Inc
 * @license   
 * @author singlas.in
 */


defined('MOODLE_INTERNAL') || die();


$plugin->version   = 2020052011;
$plugin->requires  = 2011120500;
$plugin->cron      = 0;
$plugin->component = 'quizaccess_proctoring_verificient';
$plugin->maturity  = MATURITY_STABLE;
$plugin->release   = 'v2.1 for Moodle 3.4+';
