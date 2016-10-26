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
 * Combined question embedded sub question renderer class.
 *
 * @package   qtype_oumultiresponse
 * @copyright  2013 The Open University
 * @author     Jamie Pratt <me@jamiep.org>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();


class qtype_essaynoedit_embedded_renderer extends qtype_renderer
    implements qtype_combined_subquestion_renderer_interface {

    public function subquestion(question_attempt $qa,
                                question_display_options $options,
                                qtype_combined_combinable_base $subq,
                                $placeno) {
        $question = $subq->question;
        $fullresponse = new qtype_combined_response_array_param($qa->get_last_qt_data());
        $response = $fullresponse->for_subq($subq);
        $responseoutput = $question->get_format_renderer($this->page);

        // Answer field.
        $step = $qa->get_last_step_with_qt_var('answer');

        if (!$step->has_qt_var('answer') && empty($options->readonly)) {
            // Question has never been answered, fill it with response template.
            $step = new question_attempt_step(array('answer'=>$question->responsetemplate));
        }

        if (empty($options->readonly)) {
            $answer = $responseoutput->response_area_input('answer', $qa,
                    $step, $question->responsefieldlines, $options->context);

        } else {
            $answer = $responseoutput->response_area_read_only('answer', $qa,
                    $step, $question->responsefieldlines, $options->context);
        }

        $files = '';
        if ($question->attachments) {
            if (empty($options->readonly)) {
                $files = $this->files_input($qa, $question->attachments, $options);

            } else {
                $files = $this->files_read_only($qa, $options);
            }
        }

        $result = '';
        $result .= html_writer::tag('div', $question->format_questiontext($qa),
                array('class' => 'qtext'));

        $result .= html_writer::start_tag('div', array('class' => 'ablock'));
        $result .= html_writer::tag('div', $answer, array('class' => 'answer'));
        $result .= html_writer::tag('div', $files, array('class' => 'attachments'));
        $result .= html_writer::end_tag('div');

        return $result;
    }
}
