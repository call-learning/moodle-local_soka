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
 * Soka project.
 *
 *
 * @package    local_soka
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Soka project Tools';
$string['sokageneralsettings'] = 'Soka General Settings';
$string['sokamanagement'] = 'Soka Management';
$string['softskillsbadge'] = 'Badge for softskill activity';
$string['softskillsbadge_help'] = 'Badge to issue when completing the softskills';
$string['softskillsbadge:emailsubject'] = 'You softskill Experience badge is ready !';
$string['softskillsbadge:emailfooter'] = 'Thank you for using the softskill test !';
$string['softskillsbadge:emaillink'] = 'Please follow this link to obtain your badge.';
$string['softskillsbadge:emailbody'] = '<p>You have completed the Softskill questionnaire on {$a->sitename}
 and we are pleased to deliver</p><p>Your Experience Badge</p><p>{$a->scoredisplay}</p>';
$string['yourscore'] = 'Your attained score of completion is {$a}';