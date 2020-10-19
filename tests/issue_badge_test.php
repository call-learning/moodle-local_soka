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
defined('MOODLE_INTERNAL') || die();

/**
 * Class obf_assertion_stub
 * @package    local_soka
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class obf_assertion_stub  extends obf_assertion {
    /**
     * @var string $error
     */
    private $error;
    /**
     * Issues the badge.
     *
     * This is overriden as the original class does hide the PHPUnit Exception
     * such as
     *
     * @return mixed Eventid(string) when event id was successfully parsed from response,
     *         true on otherwise successful operation, false otherwise.
     */
    public function process() {
        try {
            $eventid = $this->get_badge()->issue($this->get_recipients(), $this->get_issuedon(),
                $this->get_email_template(), $this->get_criteria_addendum());
            return $eventid;
        } catch (moodle_exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }
};

/**
 * Issuer Utils test case
 *
 * @package  local_soka
 * @copyright 2020 - CALL Learning - Laurent David <laurent@call-learning>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_obf_issuer_testcase extends advanced_testcase {
    /**
     * Mock badge data
     */
    protected function mock_badges() {
        // @codingStandardsIgnoreStart
        // phpcs:disable
        $badges = array(
            array(
                array(
                    array(
                        "ctime" => "1383658770",
                        "mtime" => "1383658770",
                        "name" => "Experience Badge",
                        "client_id" => "MTKUR18NL1",
                        "description" => "Get Experience Badge",
                        "image" => "data:image/png;base64,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\ngg==\n",
                        "draft" => "0",
                        "id" => "MVSLXUiDGCi1",
                        "criteria" => "",
                        "expires" => "0"),
                )
            )
        );
        // phpcs:enable
        // @codingStandardsIgnoreEnd
        set_config('softskillsbadge', $badges[0][0][0]['id'], 'local_soka');

        $stub = $this->createPartialMock(obf_client::class,
            array('get_badges', 'require_client_id', 'api_request', 'get_raw_response'));

        $stub->expects($this->any())
            ->method('get_badges')
            ->will($this->returnValue($badges));
        $stub->expects($this->any())
            ->method('get_raw_response')
            ->will($this->returnValue(array('Location: https://localhost.localdomain/v1/event/PHPUNIT/PHPUNITEVENTID')));
        return $stub;
    }

    /**
     * Test issuer population from array.
     */
    public function test_issue_badge() {
        $this->resetAfterTest();

        $obfclientstub = $this->mock_badges();
        $sentquery = array(
            'recipient' =>
                array(
                    0 => 'testmail@email.com',
                ),
            'api_consumer_id' => 'Moodle',
            'log_entry' =>
                array(
                    'course_id' => null,
                    'course_name' => null,
                    'activity_name' => null,
                    'wwwroot' => 'https://www.example.com/moodle',
                ),
            'show_report' => 1,
            'email_subject' => 'You softskill Experience badge is ready !',
            'email_body' => '<p>You have completed the Softskill questionnaire on PHPUnit test site
 and we are pleased to deliver</p><p>Your Experience Badge</p><p>Your attained score of completion is 10</p>',
            'email_footer' => 'Thank you for using the softskill test !',
            'email_link_text' => 'Please follow this link to obtain your badge.',
        );

        $obfclientstub->expects($this->any())
            ->method('api_request')
            ->with(
                '/badge//MVSLXUiDGCi1',
                'post',
                $this->callback(
                    function($other) use ($sentquery) {
                        $actualquery = $sentquery;
                        $actualquery += ['issued_on' => $other['issued_on']];
                        foreach ($other as $key => $val) {
                            if ($actualquery[$key] != $val) {
                                return false;
                            }
                        }
                        return true;
                    })
            );

        $result = \local_soka\local\utils::issue_badge(
            'testmail@email.com',
            'softskillsbadge',
            10,
            null,
            $obfclientstub,
            new obf_assertion_stub()
        );
        $this->assertTrue($result->status);
    }
}

