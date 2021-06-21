$(document).ready(function () {
    var count = $(".result-subset").length;
    var max_count = $(".result-subset:first-of-type select[name='subject_id'] option").length;
    $('#notification').modal('show');
    $("#update-notification").modal('hide');
    $(".range input").attr('disabled', true);
    $(".mobile-network").attr('disabled', true);

    $("button.filter-by").attr('disabled', true);

    $("select.filter-by").click(function () {
        var type = $(this).val();
        if (type === 'age-range' || type === 'mark-range') {
            $(".range input").attr('disabled', false);
            $(".mobile-network").attr('disabled', true).val('');
            $("button.filter-by").attr('disabled', false);
        } else if (type === 'mobile-network') {
            $(".range input").attr('disabled', true);
            $(".mobile-network").attr('disabled', false);
            $("button.filter-by").attr('disabled', false);
            $(".filter input[name='from']").val('');
            $(".filter input[name='to']").val('');
        } else if (type === 'complete' || type === 'in-progress') {
            $(".range input").attr('disabled', true);
            $(".mobile-network").attr('disabled', true);
            $("button.filter-by").attr('disabled', false);
            $(".filter input[name='from']").val('');
            $(".filter input[name='to']").val('');
        } else {
            $(".range input").attr('disabled', true);
            $(".mobile-network").attr('disabled', true);
            $("button.filter-by").attr('disabled', true);
        }
    });

    $("button.add-button").on('click', function () {
        var input = $(".subset-hidden").eq(0).clone().css("display", "block");
        if (count < max_count) {
            $("div.result-set").append(input);
            count++;
            $(".add-button").attr('disabled', false);
        }
        if (count === max_count) {
            $(".add-button").attr('disabled', true);
        }
    });

    $('.massive-update').on('click', '.delete-option', function () {
        $(this).parent().parent().remove();
        --count;
        if (count < max_count) {
            $(".add-button").attr('disabled', false);
        }
        if (count === 0) {
            $(".massive-update button[type='submit']").attr('disabled', 'true');
        }
    })

    $(".form-edit-student").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "student/update",
            data: $(this).serialize(),
            success: function (data) {
                $("#update-notification").modal('show');
                $("#update-notification .modal-body .col-md-12").empty();
                if (data[0] == false) {
                    $("#edit-student").modal('hide');
                    $("#update-notification .modal-body .col-md-12").append('<p>FAILED</p>')
                    var i;
                    for (i = 1; i < data.length; i++) {
                        $("#update-notification .modal-body .col-md-12").append('<p>' + data[i] + '</p>');
                    }
                } else {
                    $("#edit-student").modal('hide');
                    const selector = $('.table-display tr td[class="student-id"]').filter(function () {
                        return $(this).text() == data.id;
                    });
                    selector.siblings(".student-name").text(data.name);
                    selector.siblings(".student-address").text(data.address);
                    selector.siblings(".student-birthday").text(data.birthday);
                    selector.siblings(".student-departmnet").text(data.department_id);
                    selector.siblings(".student-gender").text(data.gender);
                    selector.siblings(".student-email").text(data.email);
                    selector.siblings(".student-phone").text(data.phone);
                    $("#update-notification .modal-body .col-md-12").append('<p>Update Successful</p>');
                }
            }
        })
    });

    $(".delete-student").click(function () {
        var id = $(this).parent().siblings('td:first-of-type').text();
        $("#delete-student input[name='id']").val(id);
    });

    $(".delete-department").click(function () {
        var id = $(this).parent().siblings('td:first-of-type').text();
        $("#delete-department input[name='id']").val(id);
    });

    $(".delete-result").click(function () {
        var id = $(this).parent().siblings('td:first-of-type').text();
        $("#delete-result input[name='id']").val(id);
    });

    $(".delete-subject").click(function () {
        var id = $(this).parent().siblings('td:first-of-type').text();
        $("#delete-subject input[name='id']").val(id);
    });

    $('.update-student').click(function () {
        var selector = $("#edit-student");
        var id = $(this).parent().siblings('td:first-of-type').text();
        selector.find("input[name='id']").attr('value', id);

        var name = $(this).parent().siblings('td:nth-of-type(2)').text();
        selector.find("input[name='name']").attr('value', name);

        var department = $(this).parent().siblings('td:nth-of-type(3)').text();
        selector.find("select[name='department_id'] option[value='" + department + "']").attr('selected', 'selected');

        var email = $(this).parent().siblings('td:nth-of-type(4)').text();
        selector.find("input[name='email']").attr('value', email);

        var gender = $(this).parent().siblings('td:nth-of-type(5)').text();
        selector.find("select[name='gender'] option[value='" + gender + "']").attr('selected', 'selected');

        var birthday = $(this).parent().siblings('td:nth-of-type(6)').text();
        selector.find("input[name='birthday']").attr('value', birthday);

        var address = $(this).parent().siblings('td:nth-of-type(7)').text();
        selector.find("input[name='address']").attr('value', address);

        var phone = $(this).parent().siblings('td:nth-of-type(8)').text();
        selector.find("input[name='phone']").attr('value', phone);
    });

    $('.update-department').click(function () {
        var selector = $("#edit-department");
        var id = $(this).parent().siblings('td:first-of-type').text();
        selector.find("input[name='id']").attr('value', id);

        var name = $(this).parent().siblings('td:nth-of-type(2)').text();
        selector.find("input[name='name']").attr('value', name);
    });

    $('.update-subject').click(function () {
        var selector = $("#edit-subject");
        var id = $(this).parent().siblings('td:first-of-type').text();
        selector.find("input[name='id']").attr('value', id);

        var name = $(this).parent().siblings('td:nth-of-type(2)').text();
        selector.find("input[name='name']").attr('value', name);

        var department = $(this).parent().siblings('td:nth-of-type(3)').text();
        selector.find("select[name='department_id'] option[value='" + department + "']").attr('selected', 'selected');
    });

    $('.update-result').click(function () {
        var selector = $("#edit-result");
        var id = $(this).parent().siblings('td:first-of-type').text();
        selector.find("input[name='id']").attr('value', id);

        var student_id = $(this).parent().siblings('td:nth-of-type(2)').text();
        selector.find("input[name='student_id']").attr('value', student_id);

        var subject_id = $(this).parent().siblings('td:nth-of-type(3)').text();
        selector.find("select[name='subject_id'] option[value='" + subject_id + "']").attr('selected', 'selected');

        var mark = $(this).parent().siblings('td:nth-of-type(4)').text();
        selector.find("input[name='mark']").attr('value', mark);
    })

    $(".massive-update button.btn-secondary").click(function () {
        location.href = '/student';
    })

    $(".result-subset select")
});

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




