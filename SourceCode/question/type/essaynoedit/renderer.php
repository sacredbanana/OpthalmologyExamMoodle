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
 * Essay question renderer class.
 *
 * @package    qtype
 * @subpackage essay
 * @copyright  2009 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/question/type/essay/renderer.php');


/**
 * Generates the output for essay questions.
 *
 * @copyright  2009 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_essaynoedit_renderer extends qtype_essay_renderer {
    public function formulation_and_controls(question_attempt $qa,
            question_display_options $options) {
		$step = $qa->get_last_step_with_qt_var('answer');
		if($step->has_qt_var('answer')) {
			$options->readonly = true;
		}
		return parent::formulation_and_controls($qa, $options);
    }
}


/**
 * A base class to abstract out the differences between different type of
 * response format.
 *
 * @copyright  2014 Jesper Madsen
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class qtype_essaynoedit_format_renderer_base extends qtype_essay_format_renderer_base {

}

/**
 * An essay format renderer for essays where the student should not enter
 * any inline response.
 *
 * @copyright  2014 Jesper Madsen
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_essaynoedit_format_noinline_renderer extends qtype_essay_format_noinline_renderer {

    protected function class_name() {
        return 'qtype_essaynoedit_noinline';
    }
}

/**
 * An essay format renderer for essays where the student should use the HTML
 * editor without the file picker.
 *
 * @copyright  2014 Jesper Madsen
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_essaynoedit_format_editor_renderer extends qtype_essay_format_editor_renderer {
    protected function class_name() {
        return 'qtype_essaynoedit_editor';
    }
}


/**
 * An essay format renderer for essays where the student should use the HTML
 * editor with the file picker.
 *
 * @copyright  2014 Jesper Madsen
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_essaynoedit_format_editorfilepicker_renderer extends qtype_essay_format_editorfilepicker_renderer {
    protected function class_name() {
        return 'qtype_essaynoedit_editorfilepicker';
    }
}


/**
 * An essay format renderer for essays where the student should use a plain
 * input box, but with a normal, proportional font.
 *
 * @copyright  2014 Jesper Madsen
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_essaynoedit_format_plain_renderer extends qtype_essay_format_plain_renderer {

    protected function class_name() {
        return 'qtype_essaynoedit_plain';
    }
}


/**
 * An essay format renderer for essays where the student should use a plain
 * input box with a monospaced font. You might use this, for example, for a
 * question where the students should type computer code.
 *
 * @copyright  2011 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_essaynoedit_format_monospaced_renderer extends qtype_essay_format_monospaced_renderer {
    protected function class_name() {
        return 'qtype_essaynoedit_monospaced';
    }
}
