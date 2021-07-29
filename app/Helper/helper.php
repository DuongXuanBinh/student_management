<?php
if (!function_exists('showSubjects')) {
    function showSubjects($name, $subjects, $subject_id)
    {
        echo "<select name='" . $name . "' class='form-control'>";
        foreach ($subjects as $subject) {
            if ($subject->id == $subject_id) {
                echo "<option value='" . $subject->id . "' selected='selected'>" . $subject->name . "</option>";
            } else {
                echo "<option value='" . $subject->id . "'>" . $subject->name . "</option>";
            }
        }
        echo "</select>";
    }
}

if (!function_exists('showSubject')) {
    function showSubject($name, $subjects)
    {
        echo "<select name='" . $name . "' class='form-control'>";
        foreach ($subjects as $subject) {
            echo "<option value='" . $subject->id . "'>" . $subject->name . "</option>";
        }
        echo "</select>";
    }
}
if (!function_exists('showError')) {
    function showError($name, $i, $errors)
    {
        if (!empty($errors->get($name .'.'. $i))) {
            foreach ($errors->get($name .'.'. $i) as $error) {
                echo '<p class="errorTxt">'.$error.'</p>';
            }
        }
    }
}
