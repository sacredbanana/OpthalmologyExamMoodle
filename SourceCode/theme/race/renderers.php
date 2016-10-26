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
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package    theme_bootstrapbase
 * @copyright  2013
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**     Source: http://ajmm.org/2011/06/using-php-reflection-to-read-a-protected-property/
 * Get the value of a property using reflection.
 *
 * @param object|string $class
 *     The object or classname to reflect. An object must be provided
 *     if accessing a non-static property.
 * @param string $propertyName The property to reflect.
 * @return mixed The value of the reflected property.
 */
 if(!function_exists("getReflectedPropertyValue")) {
 function getReflectedPropertyValue($class, $propertyName)
{
    $reflectedClass = new ReflectionClass($class);
    $property = $reflectedClass->getProperty($propertyName);
    $property->setAccessible(true);
 
    return $property->getValue($class);
}
}

include_once($CFG->dirroot . "/mod/quiz/renderer.php");
 
class theme_race_mod_quiz_renderer extends mod_quiz_renderer {
 
       public function navigation_panel(quiz_nav_panel_base $panel) {

        $output = '';
        $userpicture = $panel->user_picture();
        if ($userpicture) {
            $fullname = fullname($userpicture->user);
            if ($userpicture->size === true) {
                $fullname = html_writer::div($fullname);
            }
            $output .= html_writer::tag('div', $this->render($userpicture) . $fullname,
                    array('id' => 'user-picture', 'class' => 'clearfix'));
        }
        $output .= $panel->render_before_button_bits($this);

        $bcc = $panel->get_button_container_class();
        $output .= html_writer::start_tag('div', array('class' => "qn_buttons $bcc"));
        foreach ($panel->get_question_buttons() as $button) {
            $output .= $this->render_race_button($button, $panel);
        }
        $output .= html_writer::end_tag('div');

        $output .= html_writer::tag('div', $panel->render_end_bits($this),
                array('class' => 'othernav'));

        $this->page->requires->js_init_call('M.mod_quiz.nav.init', null, false,
                quiz_get_js_module());

        return $output;
    }
    
    /**
     * Returns the quizzes navigation button
     *
     * @param quiz_nav_question_button $button
     */
    protected function render_race_button(quiz_nav_question_button $button, $panel) {
		$attemptobj = getReflectedPropertyValue($panel, 'attemptobj');
		$quba = getReflectedPropertyValue($attemptobj, 'quba');
		$qas = getReflectedPropertyValue($quba, 'questionattempts');
		
		
        $classes = array('qnbutton', $button->stateclass, $button->navmethod);
        $attributes = array();

        if ($button->currentpage) {
            $classes[] = 'thispage';
            $attributes[] = get_string('onthispage', 'quiz');
        }

        // Flagged?
        if ($button->flagged) {
            $classes[] = 'flagged';
            $flaglabel = get_string('flagged', 'question');
        } else {
            $flaglabel = '';
        }
        $attributes[] = html_writer::tag('span', $flaglabel, array('class' => 'flagstate'));

        if (is_numeric($button->number)) {
            $qnostring = 'questionnonav';
        } else {
            $qnostring = 'questionnonavinfo';
        }

        $a = new stdClass();
        $a->number = $button->number;
        $a->attributes = implode(' ', $attributes);
        $slot = $a->number;
		if($slot > 1) {
			$qa = $qas[$slot];
			$q = $qa->get_question();
			
			if(is_a($q, 'qtype_stagedessay_question')) {
				$prevqa = $qas[$slot-1];
				$prevq = $prevqa->get_question();
				if(is_subclass_of($prevq, 'qtype_essay_question')) {
					$step = $prevqa->get_last_step_with_qt_var('answer');
					if(!$step->has_qt_var('answer')) {
							array_push($classes, 'lockedstaged');
					}
				}
			}
		}
		
        $tagcontents = html_writer::tag('span', '', array('class' => 'thispageholder')) .
                        html_writer::tag('span', '', array('class' => 'trafficlight')) .
                        get_string($qnostring, 'quiz', $a);
        $tagattributes = array('class' => implode(' ', $classes), 'id' => $button->id,
                                  'title' => $button->statestring);

        if ($button->url) {
            return html_writer::link($button->url, $tagcontents, $tagattributes);
        } else {
            return html_writer::tag('span', $tagcontents, $tagattributes);
        }
    }
 
}

