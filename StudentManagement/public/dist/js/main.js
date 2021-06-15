$(window).on('load', function () {
    // $('#notification').modal('show');
    $(".range input").attr('disabled', true);
    $(".mobile-network").attr('disabled', true);
    $("button.filter-by").attr('disabled', true);
});

$("select.filter-by").change(function (){
    var type = $(this).val();
    if(type === 'age-range'|| type === 'mark-range'){
        $(".range input").attr('disabled', false);
        $(".mobile-network").attr('disabled', true);
        $("button.filter-by").attr('disabled', false);
    } else if(type === 'mobile-network'){
        $(".range input").attr('disabled', true);
        $(".mobile-network").attr('disabled', false);
        $("button.filter-by").attr('disabled', false);
    } else if (type === 'complete' || type === 'in-progress'){
        $(".range input").attr('disabled', true);
        $(".mobile-network").attr('disabled', true);
        $("button.filter-by").attr('disabled', false);
    } else{
        $(".range input").attr('disabled', true);
        $(".mobile-network").attr('disabled', true);
        $("button.filter-by").attr('disabled', true);
    }
});

var count = 0;
$(".add-button").on('click', function () {

    var new_input = "<div class=\"row subject-mark\">\n" +
        "                                    <div class=\"col-md-12\">\n" +
        "                                        <div class=\"col-md-2\">\n" +
        "                                            <label>Subject: </label>\n" +
        "                                        </div>\n" +
        "                                        <div class=\"col-md-6\">\n" +
        "                                            <select name=\"department_id\">\n" +
        "                                                <option value=\"\">Romaguera PLC</option>\n" +
        "                                            </select>\n" +
        "                                        </div>\n" +
        "                                        <div class=\"col-md-2\">\n" +
        "                                            <label>Mark: </label>\n" +
        "                                        </div>\n" +
        "                                        <div class=\"col-md-2\">\n" +
        "                                            <input type=\"text\" name=\"text\">\n" +
        "                                        </div>\n" +
        "                                        <a class=\"delete-subject\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-x-lg\" viewBox=\"0 0 16 16\">\n" +
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

$('.modal-body').on('click', '.delete-subject', function () {
    $(this).parent().parent().remove();
    count--;
    if (count < 3) {
        $(".add-button").attr('disabled', false);
    }
})





