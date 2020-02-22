
$(document).ready(function(){
   validate(
                        $("form.login_form"),
                        "",
                        false,
                        "login"
                        );
  
});
function login(){
    let username=$('.email').val();
    let password=$('.password').val();
    $.ajax({
                url: base_url + "/Authentication/login/",
                type: 'POST',
                dataType: 'json',
                data:{username:username,password:password},
                async: true,
                beforeSend: function (xhr) {
                     xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                    // setting a timeout
                    $(".page-loader").show();
                },
                success: function (data)
                {
                    $(".page-loader").hide();
                    if (data['status'] == 1) {
                       location.href=base_url+'/admin'
                    }
                    else{
                        $('.error_screen').html(data['msg']);
                    }
                }
            });
}