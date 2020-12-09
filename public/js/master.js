var Render_Data = function () {

};
$(document).ready(function () {
    "use strict";

    $(document).on("submit",".ajaxForm",function (event) {
        event.preventDefault(); //prevent default action
        var post_url = $(this).attr("action"); //get form action url
        var request_method = $(this).attr("method"); //get form GET/POST method
        var form_data = new FormData(this); //Encode form elements for submission
        var name = $(this).data('name');
        var current_data = $(this).serializeArray();
        var id_current_data = current_data[1]['value']
        var old_name_Su = $("."+ name +" .btn-load").html();
        $.ajax({
            url : post_url,
            type: request_method,
            data : form_data,
            beforeSend: function() {
                // setting a timeout
                $("."+ name +" .btn-load").html("Loading...");
                $("."+ name +" .btn-load").prop("disabled", true);
            },
            contentType: false,
            processData:false,
            xhr: function(){
                //upload Progress
                var xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', function(event) {
                        $("."+ name +" .btn").prop("disabled", true);
                    }, true);
                }
                return xhr;
            }
        }).done(function(data){
            $("."+ name +" .btn-load").html(old_name_Su);
            $("."+ name +" .btn-load").prop("disabled", false);
            if(data.message != null)
            {
                $("."+ name +" .btn").prop("disabled", false);
                $('.'+name+' .error').remove();
                toastr.error(data.message);
            }
            else if(data.errors != null)
            {
                $("."+ name +" .btn").prop("disabled", false);
                $('.'+name+' .error').remove();
                $('.'+name+' .form-control').removeClass('border-danger');
                $.each(data.errors ,function (index,val) {
                    toastr.error(val);
                    $('.'+name+' #'+index).addClass('border-danger');
                    $('.'+name+' #'+index).after('<span class="error" id="error_'+ index +'" style="color: red">'+val+'</span>');
                });
            }
            else if (data.error != null){
                $("."+ name +" .btn").prop("disabled", false);
                toastr.error(data.error);
                if(data.redirect != null){
                    window.location.href = data.redirect;
                }
            }
            else if(data.redirect != null){
                window.location.href = data.redirect;
            }
            else
            {
                toastr.success(data.success);
                Render_Data();
                $('.'+name+' .error').remove();
                $('.'+name+' .form-control').removeClass('border-danger');
                $("."+ name +" .btn").prop("disabled", false);
                if(data.url != null){
                    window.setTimeout(function(){
                        window.location.href = data.url;
                    }, 2000);
                }
                if(data.redirect != null){
                    window.location.href = data.redirect;
                }
                $('.box_img').addClass('d-none');
                $(".error_f").html('');
                $(".cls").val('');
            }
        })
        .fail(function(xhr, status, error){
            $("."+ name +" .btn").prop("disabled", false);
            $('.'+name+' .error').remove();
            toastr.error(xhr);
            toastr.error(status);
            toastr.error(error);
        });
    });

});
