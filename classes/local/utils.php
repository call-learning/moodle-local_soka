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

namespace local_soka\local;

use obf_assertion;
use obf_badge;
use obf_client;
use obf_issue_event;

defined('MOODLE_INTERNAL') or die();

/**
 * Class utils
 *
 * @package    local_soka
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class utils {

    /**
     * Score value => do not display score
     */
    const NO_SCORE = -1;

    /**
     * Default type for badge
     */
    const DEFAULT_TYPE = 'softskillsbadge';

    /**
     * Issue a badge from given parameters
     *
     * @param string $email
     * @param string $type
     * @param int $score
     * @param string|null $badgeid
     * @param obf_client|null $obfclient
     * @param null $assertion
     * @return false|string
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function issue_badge($email, $type, $score = self::NO_SCORE, $badgeid = null, $obfclient = null,
        $assertion = null) {
        global $CFG, $DB, $USER;

        require_once($CFG->dirroot . '/local/obf/class/badge.php');
        require_once($CFG->dirroot . '/local/obf/class/event.php');
        $badge = self::get_badge($type, $badgeid, $obfclient);

        $recipients = array();
        $recipients[] = $email;
        $now = time();
        $criteriaaddendum = '';

        list ($emailsubject, $emailfooter, $emaillinktext, $emailbody) = self::fill_email_message($type, $score);

        if (!$assertion) {
            $assertion = obf_assertion::get_instance();
        }
        $assertion->set_badge($badge);
        $assertion->set_issuedon($now)->set_recipients($recipients);
        $assertion->set_criteria_addendum($criteriaaddendum);
        $assertion->get_email_template()
            ->set_subject($emailsubject)
            ->set_footer($emailfooter)
            ->set_body($emailbody)
            ->set_link_text($emaillinktext);

        $success = $assertion->process();

        // Badge was successfully issued.
        if ($success) {
            if (!is_bool($success)) {
                $issuevent = new obf_issue_event($success, $DB);
                $issuevent->set_userid($USER->id);
                $issuevent->save($DB);
                return (object) ['status' => true];
            }
        } else {
            return (object) ['status' => false, 'error' => $assertion->get_error()];
        }
    }

    /**
     * Get a badge definition
     *
     * @param string $type
     * @param string $badgeid
     * @param obf_client $obfclient
     * @return obf_badge
     * @throws \dml_exception
     */
    public static function get_badge($type, $badgeid, $obfclient = null) {
        if (!$badgeid) {
            $badgeid = get_config('local_soka', $type);
        }

        if (!$badgeid) {
            $badgeid = get_config('local_soka', self::DEFAULT_TYPE);
        }
        return obf_badge::get_instance($badgeid, $obfclient);
    }

    /**
     * Fill email message
     *
     * @param string $type
     * @param int $score
     * @return array
     * @throws \coding_exception
     */
    public static function fill_email_message($type, $score) {
        global $SITE;

        $emailsubject = get_string("{$type}:emailsubject", 'local_soka');
        $emailfooter = get_string("{$type}:emailfooter", 'local_soka');
        $emaillinktext = get_string("{$type}:emaillink", 'local_soka');
        $scoredisplay = '';
        if ($score != self::NO_SCORE) {
            $scoredisplay = get_string('yourscore', 'local_soka', $score);
        }
        $emailbody = get_string("{$type}:emailbody", 'local_soka',
            ['scoredisplay' => $scoredisplay, 'sitename' => $SITE->fullname]);

        return [$emailsubject, $emailfooter, $emaillinktext, $emailbody];
    }
}