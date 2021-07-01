import {toJSON} from "../../bower_components/moment/src/lib/moment/to-type";

$(document).ready(function () {
    var count = $(".result-set .result-subset").length;
    var flag_filter = 0;
    var max_count = $(".subset-hidden select[name='subject_id[]'] option").length;
    if (count === max_count) {
        $("button.add-button").attr('disabled', 'disabled');
    }
    var value_array = [];
    $(".result-subset").find("input[name='student_id']").attr("name", "student_id[]");
    $(".result-subset").find("select[name='subject_id']").attr("name", "subject_id[]");
    $(".result-subset").find("input[name='mark']").attr("name", "mark[]");
    $(".result-subset").find("input[name='id']").attr("name", "id[]");
    $('#notification').modal('show');
    $("#update-notification").modal('hide');
    $(".range input").attr('disabled', true);
    $(".mobile-network").attr('disabled', true);
    $("button.filter-by").attr('disabled', true);

    $(".filter").click(function () {
        if (flag_filter === 0) {
            $(".filter-student").css("display", "block");
            flag_filter = 1;
        } else {
            $(".filter-student").css("display", "none");
            flag_filter = 0;
        }
    });

    $(".filter-student button[type='submit']").click(function () {
        var age_from = $(".filter-student input[name='age_from']").text();
        var age_to = $(".filter-student input[name='age_to']").text();
        var mark_from = $(".filter-student input[name='mark_from']").text();
        var mark_to = $(".filter-student input[name='mark_to']").text();
        if (age_from === '') {
            $(".filter-student input[name='age_from']").val(0).css('color', 'transparent');
        }
        if (age_to === '') {
            $(".filter-student input[name='age_to']").val(100).css('color', 'transparent');
        }
        if (mark_from === '') {
            $(".filter-student input[name='mark_from']").val(0).css('color', 'transparent');
        }
        if (mark_to === '') {
            $(".filter-student input[name='mark_to']").val(10).css('color', 'transparent');
        }
        if ($("#vinaphone").is(':unchecked') && $("#viettel").is(':unchecked') && $("#mobiphone").is(':unchecked')) {
            $("#vinaphone, #mobiphone, #viettel").attr('checked', 'checked').css('color', 'transparent');
        }
        if ($("#complete").is(':unchecked') && $("#in-progress").is(':unchecked')) {
            $("#complete, #in-progress").attr('checked', 'checked').css('color', 'transparent');
        }
    });

    var student_id = $(".update-student-form input[name='id']").val();

    $(".update-student-form").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "PUT",
            url: "students/" + student_id,
            data: {query: $(this).serialize(), id: student_id},
            success: function (data) {
                alert('Failed');
                $("#update-notification").modal('show');
                $("#update-notification .modal-body .col-md-12").empty();
                $(this).find("input[name='name']").text(data.name);
                $(this).find("input[name='address']").text(data.address);
                $(this).find("input[name='birthday']").text(data.birthday);
                var department_name = $(this).find("option[value='" + data.department_id + "']").text();
                $(this).find("select[name='department_id']").text(department_name);
                if (data.gender === '0') {
                    $(this).find("select[name='gender']").html('Female');
                } else {
                    $(this).find("select[name='gender']").html('Male');
                }
                $(this).find("input[name='email']").text(data.email);
                $(this).find("input[name='phone']").text(data.phone);
                $("#update-notification .modal-body .col-md-12").append('<p>Update Successful</p>');
                // }
            },
            error: function (response) {
                alert(toJSON(response));
                $("#update-notification").modal('show');
                $("#update-notification .modal-body .col-md-12").empty();
                $("#update-notification .modal-body .col-md-12").append('<p>FAILED</p>')
                var i;
                for (i = 1; i < response.length; i++) {
                    $("#update-notification .modal-body .col-md-12").append('<p>' + response[i] + '</p>');
                }
            }
        })
    });

    $(".delete-student").click(function () {
        var id = $(this).parent().siblings('td:first-of-type').text();
        var action = '/students/' + id;
        $("#delete-student input[name='id']").val(id);
        $("#delete-student form").attr('action', action);
    });

    $(".delete-department").click(function () {
        var id = $(this).parent().siblings('td:first-of-type').text();
        var action = '/departments/' + id;
        $("#delete-department input[name='id']").val(id);
        $("#delete-department form").attr('action', action);
    });

    $(".delete-result").click(function () {
        var id = $(this).parent().siblings('td:first-of-type').text();
        var action = '/results/' + id;
        $("#delete-result input[name='id']").val(id);
        $("#delete-result form").attr('action', action);
    });

    $(".delete-subject").click(function () {
        var id = $(this).parent().siblings('td:first-of-type').text();
        var action = '/subjects/' + id;
        $("#delete-subject input[name='id']").val(id);
        $("#delete-subject form").attr('action', action);
    });

    $(".result-subset").eq(0).find("option").each(function () {
        var option = $(this).val();
        value_array.push(option);
    })

    $("button.add-button").on('click', function () {
        var input = $(".subset-hidden").eq(0).clone().removeClass("subset-hidden");
        $(".result-set .result-subset select").each(function () {
            var prevVal = $(this).data("previous");
            $(input).find("option[value='" + prevVal + "']").show();
            var value = $(this).val();
            $(this).data("previous", value);
            $(input).find("option[value='" + value + "']").hide();
            var index = value_array.indexOf(value);
            if (index > -1) {
                value_array.splice(index, 1);
            }
        });

        const random = Math.floor(Math.random() * value_array.length);
        $(input).find("select").val(value_array[random]).find("option[value='" + value_array[random] + "']").attr('selected', 'selected');
        if (count < max_count) {
            $("div.result-set").append(input);
            $(".result-set .result-subset select").each(function () {
                var selected = $(this).find("option[selected='selected']").val();
                $(".result-set .result-subset select").not(this).find("option[value = '" + selected + "']").hide();
            });
            ++count;
            $(".add-button").attr('disabled', false);
            $(".massive-update button[type='submit']").attr('disabled', false);
        }
        if (count === max_count) {
            $(".add-button").attr('disabled', true);
        }
        $(".result-set .result-subset select").change(function () {
            $(input).find("option[value='" + value_array[random] + "']").attr('selected', false);
            var prevVal = $(this).data("previous");
            $(this).find("option[value='" + prevVal + "']").attr('selected', false);
            $(".result-set .result-subset select").not(this).find("option[value='" + prevVal + "']").show();

            var value = $(this).val();
            $(this).find("option[value='" + value + "']").attr('selected', 'selected');
            $(this).data("previous", value);
            $(".result-set .result-subset select").not(this).find("option[value='" + value + "']").hide();
        });
        $("#massive-form button[type='submit']").attr('disabled', 'disabled');
        $("#massive-form").find("input[type='text']").keyup(function () {
            $("#massive-form button[type='submit']").attr('disabled', false);
            var value = $(this).val();
            $("#massive-form button[type='submit']").click(function (e) {
                if (parseFloat(value) === 0 || (parseFloat(value) && value <= 10 && value > -1)) {
                    $("p.errorTxt").html("");
                    $("#massive-form").submit();
                } else if (value === '') {
                    e.preventDefault();
                    $("p.errorTxt").html("Mark is required field and must be number between 0 and 10");
                } else {
                    e.preventDefault();
                    $("p.errorTxt").html("Mark is required field and must be number between 0 and 10");
                }
            });
        });
    });

    $('.massive-update').on('click', '.delete-option', function () {
        var x = $(this).parent().find("select").val();
        $(".result-set .result-subset select").find("option[value='" + x + "']").show().attr('selected', false);
        $(this).parent().parent().remove();
        --count;
        if (count < max_count) {
            $(".add-button").attr('disabled', false);
        }
        if (count === 0) {
            $(".massive-update button[type='submit']").attr('disabled', 'true');
        }
    })

    $(".result-set .result-subset select").each(function () {
        var value = $(this).val();
        $(this).data("previous", value)
        $(".result-set .result-subset select").not(this).find("option[value='" + value + "']").hide();
    })

    $(".result-set .result-subset select").change(function () {
        var prevVal = $(this).data("previous");
        $(".result-set .result-subset select").not(this).find("option[value='" + prevVal + "']").show();

        var value = $(this).val();
        $(this).find("option[value='" + prevVal + "']").attr("selected", false).end().find("option[value='" + value + "']").attr('selected', 'selected');
        $(this).data("previous", value);
        $(".result-set .result-subset select").not(this).find("option[value='" + value + "']").hide();
    });

    $("#massive-form").find("input[type='text']").keyup(function () {
        $("#massive-form button[type='submit']").attr('disabled', false);
        var value = $(this).val();
        $("#massive-form button[type='submit']").click(function (e) {
            if (parseFloat(value) === 0 || (parseFloat(value) && value <= 10 && value > -1)) {
                $("p.errorTxt").html("");
                $("#massive-form").submit();
            } else if (value === '') {
                e.preventDefault();
                $("p.errorTxt").html("Mark is required field and must be number between 0 and 10");
            } else {
                e.preventDefault();
                $("p.errorTxt").html("Mark is required field and must be number between 0 and 10");
            }
        });
    });
})

function toggleResetPswd(e) {
    e.preventDefault();
    $('#logreg-forms .form-signin').toggle() // display:block or none
    $('#logreg-forms .form-reset').toggle() // display:block or none
}

function toggleSignUp(e) {
    e.preventDefault();
    $('#logreg-forms .form-signin').toggle(); // display:block or none
    $('#logreg-forms .form-signup').toggle(); // display:block or none
}

$(() => {
    // Login Register Form
    $('#logreg-forms #forgot_pswd').click(toggleResetPswd);
    $('#logreg-forms #cancel_reset').click(toggleResetPswd);
    $('#logreg-forms #btn-signup').click(toggleSignUp);
    $('#logreg-forms #cancel_signup').click(toggleSignUp);
})





