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
defined('MOODLE_INTERNAL') or die();

if ($hassiteconfig) {
    $sokamanagement = new admin_category(
        'sokamanagement',
        get_string('sokamanagement', 'local_soka')
    );

    // General settings.
    $pagedesc = get_string('sokageneralsettings', 'local_soka');
    $generalsettingspage = new admin_settingpage('sokageneral',
        $pagedesc,
        array('local/soka:manage'));

    $badges = [];
    try {
        if (obf_client::has_client_id()) {
            $allbadges = obf_badge::get_badges();
            foreach ($allbadges as $key => $b) {
                $badges[$key] = $b->get_name();
            }
        }
    } catch (Exception $e) {
        debugging('Exception when retrieving badges' . $e->getMessage());
    }

    if ($badges) {
        $generalsettingspage->add(
            new admin_setting_configselect('local_soka/softskillsbadge', new lang_string('softskillsbadge', 'local_soka'),
                new lang_string('softskillsbadge_help', 'local_soka'), '', $badges)
        );
    }
    $sokamanagement->add('sokamanagement', $generalsettingspage);
    $ADMIN->add('root', $sokamanagement);
}
