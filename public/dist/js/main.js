$(document).ready(function () {
    var count = $(".result-set .result-subset").length;
    var max_count = $(".subset-hidden select[name='subject_id[]'] option").length;
    if (count === max_count) {
        $("button.add-button").attr('disabled', 'disabled');
    }
    $("#update-notification").hide();
    var value_array = [];
    $(".result-subset").eq(0).find("option").each(function () {
        var option = $(this).val();
        value_array.push(option);
    });
    $("#update-notification").modal('hide');

    if (count === 0) {
        $("button.add-button").attr('disabled', false);
        $(".massive-update button.btn").attr('disabled','disabled');
    }

    $("button.add-button").on('click', function () {
        $(".massive-update button.btn").attr('disabled',false);
        var input = $(".subset-hidden").clone(true).find("input[name='mark[]']").val('').end().removeClass("subset-hidden");
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
    });

    $('.massive-update').on('click', '.delete-option', function () {
        var x = $(this).parent().find("select").val();
        $(".result-set .result-subset select").find("option[value='" + x + "']").show().attr('selected', false);
        $(this).parent().parent().remove();
        --count;
        $(".add-button").attr('disabled', false);
        value_array.push(x);
    });



    $(".result-subset").find("input[name='mark']").attr("name", "mark[]");
    $(".result-subset").find("input[name='id']").attr("name", "id[]");
    $(".range input").attr('disabled', true);
    $(".mobile-network").attr('disabled', true);

    // $(".update-student-form").submit(function (e) {
    //     var _url = $(this).attr('action');
    //     var _token = $('input[name="_token"]').val();
    //     e.preventDefault();
    //     $.ajax({
    //         type: "put",
    //         url: _url,
    //         token: _token,
    //         data: $(this).serialize(),
    //         success: function (data) {
    //             var new_url = '/students/'+ data.slug + '/edit';
    //             history.pushState('','',new_url);
    //             $("#update-notification").modal('show');
    //             $("#update-notification .col-md-12").empty().append('<h4 class="successTxt" style="text-align: center">Update successfully</h4>');
    //             $(this).find("input[name='name']").text(data.name);
    //             $(this).find("input[name='address']").text(data.address);
    //             $(this).find("input[name='birthday']").text(data.birthday);
    //             var department_name = $(this).find("option[value='" + data.department_id + "']").text();
    //             $(this).find("select[name='department_id']").text(department_name);
    //             if (data.gender === '0') {
    //                 $(this).find("select[name='gender']").html('Female');
    //             } else {
    //                 $(this).find("select[name='gender']").html('Male');
    //             }
    //             $(this).find("input[name='email']").text(data.email);
    //             $(this).find("input[name='phone']").text(data.phone);
    //         },
    //         error: function (xhr) {
    //             $("#update-notification").modal('show');
    //             $("#update-notification .col-md-12").empty();
    //             $.each(xhr.responseJSON.errors, function (i, error) {
    //                 $("#update-notification .col-md-12").append('<p class="errorTxt" style="text-align: center">' + error + '</p>');
    //             });
    //         }
    //     })
    // });

    $(".delete-student").click(function () {
        var id = $(this).parent().siblings('input[type="hidden"]').val();
        var action = '/students/' + id;
        $("#delete-student input[name='slug']").val(id);
        $("#delete-student form").attr('action', action);
    });

    $(".delete-department").click(function () {
        var id = $(this).parent().siblings('input[type="hidden"]').val();
        var action = '/departments/' + id;
        $("#delete-department input[name='slug']").val(id);
        $("#delete-department form").attr('action', action);
    });

    $(".delete-result").click(function () {
        var id = $(this).parent().siblings('input[type="hidden"]').val();
        var action = '/results/' + id;
        $("#delete-result input[name='id']").val(id);
        $("#delete-result form").attr('action', action);
    });

    $(".delete-subject").click(function () {
        var id = $(this).parent().siblings('input[type="hidden"]').val();
        var action = '/subjects/' + id;
        $("#delete-subject input[name='slug']").val(id);
        $("#delete-subject form").attr('action', action);
    });

    $(".massive-update button.btn-secondary").click(function () {
        window.location.href = '/students';
    });


    $(".result-set .result-subset select").each(function () {
        var value = $(this).val();
        $(this).data("previous", value)
        $(this).find("option[value='" + value + "']").attr("selected", "selected");
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

    var a = $("#enroll-subject option").length;
    if (a === 0) {
        $("#enroll-subject button").attr('disabled', 'disabled');
    } else {
        $("#enroll-subject button").attr('disabled', false);
    }
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

$("input[type=checkbox]").click(function () {
    var check = $(this).is(':checked');
    if (check === true) {
        $(this).prop('checked', 'checked');
    } else {
        $(this).removeProp('checked');
    }
});


