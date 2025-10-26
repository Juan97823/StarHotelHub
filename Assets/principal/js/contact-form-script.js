/*==============================================================*/
// StarHotelHub Contact Form JS
/*==============================================================*/
(function ($) {
    "use strict";

    $("#contactForm").on("submit", function (event) {
        event.preventDefault();
        submitForm();
    });

    function submitForm(){
        // Obtener valores del formulario
        var name = $("#name").val().trim();
        var correo = $("#correo").val().trim();
        var msg_subject = $("#msg_subject").val().trim();
        var phone_number = $("#phone_number").val().trim();
        var message = $("#message").val().trim();

        // Validar campos
        if (!name || !correo || !msg_subject || !phone_number || !message) {
            formError();
            submitMSG(false, "Por favor completa todos los campos");
            return;
        }

        // Validar email
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(correo)) {
            formError();
            submitMSG(false, "Por favor ingresa un email válido");
            return;
        }

        // Enviar por AJAX
        $.ajax({
            type: "POST",
            url: base_url + "contacto/enviar",
            data: {
                name: name,
                correo: correo,
                msg_subject: msg_subject,
                phone_number: phone_number,
                message: message
            },
            dataType: "json",
            success: function(response){
                if (response.tipo === "success"){
                    formSuccess();
                    submitMSG(true, response.msg);
                } else {
                    formError();
                    submitMSG(false, response.msg);
                }
            },
            error: function(){
                formError();
                submitMSG(false, "Error al enviar el mensaje. Intenta de nuevo.");
            }
        });
    }

    function formSuccess(){
        $("#contactForm")[0].reset();
    }

    function formError(){
        $("#contactForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
            $(this).removeClass();
        });
    }

    function submitMSG(valid, msg){
        if(valid){
            var msgClasses = "h4 tada animated text-success";
        } else {
            var msgClasses = "h4 text-danger";
        }
        $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
    }
}(jQuery)); // End of use strict