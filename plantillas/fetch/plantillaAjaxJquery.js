
$.ajax({
    type: "POST",
    url: "index.php",
    data: datos,
    dataType: "text",
    success: function (response) {

        $("#resultado").val(response);

    },
    error: function(){

        alert("¡¡Error en la respuesta recibida!!")

    }
});