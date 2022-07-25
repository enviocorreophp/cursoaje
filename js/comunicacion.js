function validar(){
    //Usamos una variable para cada objeto de input
    let user = document.getElementById("user");
    let pass = document.getElementById("pass");
    //Hay que verificar que estos input cumplen con los atributos de validacion
    //if (user.validity.valid && pass.validity.valid){
    //if (user.checkValidity()  && pass.checkValidity()){
    if (user.checkValidity()){
        //El input del usuario es valido 
        //Reiniciamo por si anteriormente esta mal
        user.style.border = "1px black solid";
        user.style.borderRadius = "2px";
        if (pass.checkValidity()){
            //Reiniciamos el estilo por si antes estaba mal
            pass.style.border = "1px black solid";
            pass.style.borderRadius = "2px";
            //El pass es valido asi que ya podemos mandar los datos
            //LLamamos a la funcion que envia los datos
            enviar();
        }else{
            //Mostramos de alguna manera que el pass es invalido
            pass.style.border = "2px red solid";
        }
    }else{
        //Hay que mostrar de alguna manera que no es valio ese input
        user.style.border = "2px red solid";
    }
}

function enviar(){
    //Usamos una variable para cada objeto de input
    let user = document.getElementById("user");
    let pass = document.getElementById("pass");
    let boton = document.getElementById("boton");
    let salida = document.getElementById("salida");
    //Podemos empezar con la comunicacion
    let respuesta = new XMLHttpRequest();
    respuesta.onreadystatechange = function(){
        //Controlamos los estados de los cambios de la comunicacion
        switch (respuesta.readyState){
            case 1: //Se ha empezado la comunicación
                    boton.innerHTML = '<div class="loader"></div>';
                    
                    break;
            case 4: //Se ha terminado la comunicacion
                    //El boton deje de mostar el spinner
                    boton.innerHTML = '<img src="./img/btlogin.jpg" alt="Hacer Login"></img>';
                    //Vemos el estado de la comunicacion a ver si es el 200
                    if (respuesta.status == 200){
                        //Se ha recibido correctamente la respuesta
                        // en respuesta.responseText tenemos la respuesta
                        switch (respuesta.responseText){
                            case "OK": //Redirecciono a home porque ya se que tiene session iniciada
                                        window.location.href = "../home.php";
                                        break;
                            case "KO": //Caso en el que el usuario no esta
                                        salida.innerHTML = "<p class='error'> El usuario no pertenece al sistema<p>";
                                        salida.innerHTML += "<p> <a href='../registro.html'>Registrate</a> en nuestra super comunidad <p>";
                                        break;
                            case "ERRC": //Error de consulta
                                        salida.innerHTML = "<p class='error'>No podemos comprobar la identidad. Prueba mas tarde.</p>";
                                        break;
                            case "ERRCO": //Error de conexion
                                        salida.innerHTML = "<p class='error'>No podemos comprobar la identidad. Prueba mas tarde.</p>";
                                        break;
                            case "ERROR": //Error de consulta
                                        salida.innerHTML = "<p class='error'>Problemas con el sistema. LLama a 923 33 33 33</p>";
                                        break;
                            //Caso de control en las pruebas
                            default: salida.innerHTML = "<p>"+respuesta.responseText+"</p>";
                        }

                    }else{
                        //hay algun error del tipo 403, 404. etc
                        salida.innerHTML = "<p class='error'>Error en la comunicacion</p>"
                    }
                    break;
        }
    } 
    //Preparamos la comunicacion
    respuesta.open("POST","../php/login.php");
    respuesta.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    respuesta.send("user="+user.value+"&pass="+pass.value);
}