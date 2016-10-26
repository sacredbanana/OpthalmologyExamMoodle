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
 * Defines the hooks necessary to make the shortanswernoedit question type combinable
 *
 * @package   qtype_essaynoedit
 * @copyright  2014
 * @author     Jesper Madsen
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class qtype_combined_combinable_type_essaynoedit extends qtype_combined_combinable_type_base {

    protected $identifier = 'essaynoedit';

    protected function extra_question_properties() {
		return array();
        //return array('answernumbering' => 'abc') + $this->combined_feedback_properties();
    }

    protected function extra_answer_properties() {
        return array('feedback' => array('text' => '', 'format' => FORMAT_PLAIN));
    }

/*    public function subq_form_fragment_question_option_fields() {
        return array('shuffleanswers' => false);
    }*/

    protected function transform_subq_form_data_to_full($subqdata) {
		$data = $this->add_question_properties($subqdata);
        return $data;
    }

    protected function third_param_for_default_question_text() {
        return 'v';
    }
}

class qtype_combined_combinable_essaynoedit extends qtype_combined_combinable_accepts_vertical_or_horizontal_layout_param {

    /**
     * @param moodleform      $combinedform
     * @param MoodleQuickForm $mform
     * @param                 $repeatenabled
     */
    public function add_form_fragment(moodleform $combinedform, MoodleQuickForm $mform, $repeatenabled) {
	        $qtype = question_bank::get_qtype('essay');

        $mform->addElement('header', 'responseoptions', get_string('responseoptions', 'qtype_essay'));
        $mform->setExpanded('responseoptions');

        $mform->addElement('select', $this->form_field_name('responseformat'),
                get_string('responseformat', 'qtype_essay'), $qtype->response_formats());
        $mform->setDefault($this->form_field_name('responseformat'), 'editor');

        $mform->addElement('select', $this->form_field_name('responserequired'),
                get_string('responserequired', 'qtype_essay'), $qtype->response_required_options());
        $mform->setDefault($this->form_field_name('responserequired'), 1);
        $mform->disabledIf($this->form_field_name('responserequired'), $this->form_field_name('responseformat'), 'eq', 'noinline');

        $mform->addElement('select', $this->form_field_name('responsefieldlines'),
                get_string('responsefieldlines', 'qtype_essay'), $qtype->response_sizes());
        $mform->setDefault($this->form_field_name('responsefieldlines'), 15);
        $mform->disabledIf($this->form_field_name('responsefieldlines'), $this->form_field_name('responseformat'), 'eq', 'noinline');

        $mform->addElement('select', $this->form_field_name('attachments'),
                get_string('allowattachments', 'qtype_essay'), $qtype->attachment_options());
        $mform->setDefault($this->form_field_name('attachments'), 0);

        $mform->addElement('select', $this->form_field_name('attachmentsrequired'),
                get_string('attachmentsrequired', 'qtype_essay'), $qtype->attachments_required_options());
        $mform->setDefault($this->form_field_name('attachmentsrequired'), 0);
        $mform->addHelpButton($this->form_field_name('attachmentsrequired'), 'attachmentsrequired', 'qtype_essay');
        $mform->disabledIf($this->form_field_name('attachmentsrequired'), $this->form_field_name('attachments'), 'eq', 0);

        $mform->addElement('header', 'responsetemplateheader', get_string('responsetemplateheader', 'qtype_essay'));
        $mform->addElement('editor', $this->form_field_name('responsetemplate'), get_string('responsetemplate', 'qtype_essay'),
                array('rows' => 10),  array_merge(array(), array('maxfiles' => 0)));
        $mform->addHelpButton($this->form_field_name('responsetemplate'), 'responsetemplate', 'qtype_essay');

        $mform->addElement('header', 'graderinfoheader', get_string('graderinfoheader', 'qtype_essay'));
        $mform->setExpanded('graderinfoheader');
        $mform->addElement('editor', $this->form_field_name('graderinfo'), get_string('graderinfo', 'qtype_essay'),
                array('rows' => 10), array());

        /*$this->add_per_answer_fields($mform, get_string('answerno', 'qtype_shortanswer', '{no}'),
                question_bank::fraction_options());

        $this->add_interactive_settings();
		
        $mform->addElement('advcheckbox', $this->form_field_name('shuffleanswers'), get_string('shuffle', 'qtype_gapselect'));

        $answerels = array();
        $answerels[] = $mform->createElement('text', $this->form_field_name('answer'),
                                             get_string('choiceno', 'qtype_multichoice', '{no}'), array('size'=>55));
        $mform->setType($this->form_field_name('answer'), PARAM_TEXT);
        $answerels[] = $mform->createElement('advcheckbox',
                                             $this->form_field_name('correctanswer'),
                                             get_string('correct', 'question'),
                                             get_string('correct', 'question'));

        $answergroupel = $mform->createElement('group',
                                               $this->form_field_name('answergroup'),
                                               get_string('choiceno', 'qtype_multichoice', '{no}'),
                                               $answerels,
                                               null,
                                               false);
        if ($this->questionrec !== null) {
            $countanswers = count($this->questionrec->options->answers);
        } else {
            $countanswers = 0;
        }*/

    }

    public function data_to_form($context, $fileoptions) {
        $mroptions = array('answer' => "hej", 'correctanswer' => array());
        return parent::data_to_form($context, $fileoptions) + $mroptions;
    }

    public function validate() {
        $errors = array();
        return $errors;
    }

    public function has_submitted_data() {
		return true;
        /*return $this->submitted_data_array_not_empty('correctanswer') ||
                $this->submitted_data_array_not_empty('answer') ||
                parent::has_submitted_data();*/
    }

}
