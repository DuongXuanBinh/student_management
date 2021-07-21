<?php
if (!function_exists('showSubject')) {
    function showSubjects($name, $subjects, $subject_id)
    {
        echo "<select name='" . $name . "'>";
        foreach ($subjects as $subject) {
            if ($subject->id == $subject_id) {
                echo "<option value='" . $subject->id . "' selected='selected'>" . $subject->name . "</option>";
            } else {
                echo "<option value='" . $subject->id . "'>" . $subject->name . "</option>";
            }
        }
        echo "</select>";
    }

    function showSubject($name, $subjects)
    {
        echo "<select name='" . $name . "'>";
        foreach ($subjects as $subject) {
            echo "<option value='" . $subject->id . "'>" . $subject->name . "</option>";
        }
        echo "</select>";
    }
}
