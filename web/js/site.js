$(document).ready(function(){
    $("#signUpHere").validate({
        rules:{
            user_name:{
                required:true
            },
            user_email:{
                required:true,
                email: true
            },
            user_notes:{
                required:true
            },
            gender:{
                required:true
            }
        },
        messages:{
            user_name:"Enter your full name",
            user_notes:"Please tell us why you want to join",
            user_email:{
                required:"Enter your email address",
                email:"Enter valid email address"
            }
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight:function(element, errorClass, validClass) {
            $(element).parents('.control-group').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.control-group').removeClass('error');
            $(element).parents('.control-group').addClass('success');
        }
    });

    $(function() {
        $('form[data-async]').live('submit', function(event) {
            var $form = $(this);
            var $target = $($form.attr('data-target'));

            $.ajax({
                type: $form.attr('method'),
                url: $form.attr('action'),
                data: $form.serialize(),

                success: function(data, status) {
                    $target.html(data);
                }
            });

            event.preventDefault();
        });
    });

    // So non-Chrome browsers will honor rel=external
    function externalLinks() {
        if (!document.getElementsByTagName) return;
        var anchors = document.getElementsByTagName("a");
        for (var i=0; i<anchors.length; i++) {
            var anchor = anchors[i];
            if (anchor.getAttribute("href") &&
                anchor.getAttribute("rel") == "external")
                anchor.target = "_blank";
        }
    }
    window.onload = externalLinks;
});