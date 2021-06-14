$(window).on('load', function() {
    // $('#notification').modal('show');

});


$(".filter-student").on('click',function () {
    $(".filter-by").css("display","inline");
    $(".button-filter").attr('disabled',true);
    $("#filter-by").on('change',function(){
        $(".button-filter").attr('disabled',false);
        var filter = $(this).val();
        if (filter === "age-range" || filter === "mark-range"){
            $(".range").css("display","inline");
            $(".operator").css("display","none").attr('name','');
            if(filter === "age-range"){
                $("form.filter").attr('action','/student/age-filter')
            }else
            {
                $("form.filter").attr('action','/student/mark-filter')
            }
        }else if (filter === "mobile-operator"){
            $(".operator").css("display","inline");
            $(".range").css("display","none");
            $("#from, #to").attr('name','');
            $("form.filter").attr('action','/student/mobile-operator-filter');
        }else{
            $("#from, #to").attr('name','');
            $(".operator").css("display","none").attr('name','');
            $(".range").css("display","none");
            if(filter === "complete"){
                $("form.filter").attr('action','/student/complete-filter');
            }else
            {
                $("form.filter").attr('action','/student/in-progress-filter');
            }
        }
    })
})
var count = 0;
$(".add-button").on('click',function () {

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
    if(count < 3){
        $("#massive-update div.modal-body").append(new_input);
        count++;
        $(".add-button").attr('disabled',false);
    }
    if(count === 3){
        $(".add-button").attr('disabled',true);
    }
});

$('.modal-body').on('click','.delete-subject',function () {
    $(this).parent().parent().remove();
    count--;
    if(count < 3){
        $(".add-button").attr('disabled',false);
    }
})





