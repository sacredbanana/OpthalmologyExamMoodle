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
 * Essay question definition class.
 *
 * @package    qtype
 * @subpackage essaynoedit
 * @copyright  2014 Jesper Madsen
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/question/type/essay/question.php');

/**
 * Represents an essay question with no editing abilities.
 *
 * @copyright  2014 Jesper Madsen
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_essaynoedit_question extends qtype_essay_question {
    public function is_same_response(array $prevresponse, array $newresponse) {
		if (array_key_exists('answer', $prevresponse) && $prevresponse['answer'] !== $this->responsetemplate) {
			$value1 = (string) $prevresponse['answer'];
			if(strlen(trim($value1)) > 0) return true;
		}
		return parent::is_same_response($prevresponse, $newresponse);
    }
}
