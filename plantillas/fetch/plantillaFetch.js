
fetch("index.php", {

    method: "POST",
    body: datos

})

    .then(response => {

        if (response.ok){

            return response.json();//tipo de respuesta que esperamos recibir

        }else{

            throw 'alert("¡¡ERROR EN LA RESPUESTA DEL SERVIDOR!!")'

        }

    })

    .then(data => {

        if (data !== null) {

            console.log(data);//solo se muestra lo recibido por consola

        }else{

            alert("¡¡OBJETO RECIBIDO INCORRECTO!!")

        }

    })
    .catch(err => {

        alert(err);

    })

