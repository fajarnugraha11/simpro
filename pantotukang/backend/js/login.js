$(function(){
    $('#form-login').submit(function() {
        var username = $('#username').val();
        if(username === ''){
            $('#notification-failed').show();
            return false;
        }else{
            url = $(this).attr('action');
            form = $(this).serializeArray();

            $.post(url, form, function(response){
                if(response.status === 1) {
                    window.location.href = 'dashboard';
                }
                else {
                    $('#notification-failed').show();
                    $('#password').val('');
                }
            }, 'json');
            return false;
        }
    });
});