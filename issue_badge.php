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
 * Version information. See https://docs.moodle.org/dev/version.php for more info.
 *
 * @package    local_soka
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use local_soka\local\utils;

define('AJAX_SCRIPT', true);
require_once(__DIR__ . '/../../config.php');

$email = required_param('email', PARAM_EMAIL);
$type = optional_param('type', utils::DEFAULT_TYPE, PARAM_ALPHANUMEXT);
$score = optional_param('score', \local_soka\local\utils::NO_SCORE, PARAM_INT);

require_login();
require_sesskey();
if (get_host_from_url(get_local_referer())
    != get_host_from_url(qualified_me() . 'h5p/embed.php')) {
    echo json_encode((object) ['status' => false,
        'error' => get_string('mustbesameorigin', 'local_soka')]);
    die();
}

echo json_encode(\local_soka\local\utils::issue_badge($email, $type, $score));