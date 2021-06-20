$(document).ready(function () {
    var count = 0;
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

    $(".add-button").on('click', function () {
        $(this).parentsUntil('.modal-body').find("input[name='student_id']").attr('disabled', 'true');

        var new_input = "<div class=\"row subject-mark\">\n" +
            "                                    <div class=\"col-md-12\">\n" +
            "                                        <div class=\"col-md-2\">\n" +
            "                                            <label>Subject: </label>\n" +
            "                                        </div>\n" +
            "                                        <div class=\"col-md-6\">\n" +
            "                                            <select name=\"subject_id\">\n" +
            "                                                <option value=\"\">Romaguera PLC</option>\n" +
            "                                            </select>\n" +
            "                                        </div>\n" +
            "                                        <div class=\"col-md-2\">\n" +
            "                                            <label>Mark: </label>\n" +
            "                                        </div>\n" +
            "                                        <div class=\"col-md-2\">\n" +
            "                                            <input type=\"text\" name=\"mark\">\n" +
            "                                        </div>\n" +
            "                                        <a class=\"delete-option\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-x-lg\" viewBox=\"0 0 16 16\">\n" +
            "                                            <path d=\"M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z\"/>\n" +
            "                                        </svg></a>\n" +
            "                                    </div>\n" +
            "                                </div>"
        if (count < 3) {
            $("#massive-update div.modal-body").append(new_input);
            count++;
            $(".add-button").attr('disabled', false);
        }
        if (count === 3) {
            $(".add-button").attr('disabled', true);
        }

    });


    // $('#massive-update input#student_id').keyup(function(){
    //     var x = $(this).text();
    //
    //     if(x === ''){
    //         $(".add-button").attr('disabled','true');
    //     }else{
    //         $(".add-button").attr('disabled','false');
    //     }
    // })

    $('.modal-body').on('click', '.delete-option', function () {
        $(this).parent().parent().remove();
        --count;
        if (count < 3) {
            $(".add-button").attr('disabled', false);
        }
        if (count === 0) {
            $("#student_id").attr('disabled','false');
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

    $('.update-result').click(function (){
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

});

function toggleResetPswd(e){
    e.preventDefault();
    $('#logreg-forms .form-signin').toggle() // display:block or none
    $('#logreg-forms .form-reset').toggle() // display:block or none
}

function toggleSignUp(e){
    e.preventDefault();
    $('#logreg-forms .form-signin').toggle(); // display:block or none
    $('#logreg-forms .form-signup').toggle(); // display:block or none
}

$(()=>{
    // Login Register Form
    $('#logreg-forms #forgot_pswd').click(toggleResetPswd);
    $('#logreg-forms #cancel_reset').click(toggleResetPswd);
    $('#logreg-forms #btn-signup').click(toggleSignUp);
    $('#logreg-forms #cancel_signup').click(toggleSignUp);
})




