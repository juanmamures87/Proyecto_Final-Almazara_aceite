
fetch("index.php", {

    method: "POST",
    body: datos

})

    .then(response => {

        if (response.ok){

            return response.json();//tipo de respuesta que esperamos recibir

        }else{

            throw 'ERROR EN LA LLAMADA AJAX';

        }

    })

    .then(data => {

        if (data !== null) {

            console.log(data);//solo se muestra lo recibido por consola

        }else{

            alert('ERROR EN EL OBJETO RECIBIDO')

        }

    })
    .catch(err => {

        alert(err);

    })

