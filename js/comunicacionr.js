function estiloError(input){
    //Pone el estilo de un elemento input a error
    input.style.border = "2px red solid";
    input.style.borderRadius = "2px";
}
function estiloNormal(input){
    //ponemos el input a su estilo original 
    input.style.border = "1px black solid";
    input.style.borderRadius = "2px";
}

function validar(){
    let user = document.getElementById('user');
    let email = document.getElementById('email');
    let pass = document.getElementById('pass');
    //Validamos el formulario
    if (user.checkValidity()){
        //El usuario cumple con la validacion
        //Ponemos su estilo a normal
        estiloNormal(user);
        if (email.checkValidity()){
            //El correo cumple con la validacion
            //Ponemos su estilo al normal
            estiloNormal(email);
            if (pass.checkValidity()){
                //Todos los input estan correctos
                estiloNormal(pass);
                //Ya esta todo correcto asi que mandamos los datos
                enviar();
            }else{
                estiloError(pass);
            }
        }else{
            //El correo esta mal
            estiloError(email);
        }
    }else{
        //El usuario no cumple con la validacion
        estiloError(user);
    }
}
function enviar(){
    //Envio de los datos al servidor
    //Creamos las variables de los objetos de los input
    let user = document.getElementById('user');
    let email = document.getElementById('email');
    let pass = document.getElementById('pass');
    let boton = document.getElementById("boton");
    //Creamos la variable instancia de la conexion XMLhttpRequest
    let respuesta = new XMLHttpRequest();
    //creamos la funcion de escucha de los cambios de estado
    respuesta.onreadystatechange = function(){
        //Esta funcion escucha los cambios de estados de la comunicacion
        switch (respuesta.readyState){
            case 1: //Se inicia la comunicacion
                    boton.innerHTML = '<div class="loader"></div>';
                    break;
            case 4: //Se termina la comunicacion
                    //Quitamos el loader puesto que ya se ha terminado la comunicacion
                    boton.innerHTML = '<img src="./img/btregistro.jpg" alt="Registrar">';
                    //Miramos a ver el estado de la comunicacion
                    if (respuesta.status == 200){
                        //Todo correcto 
                        //Podemos ver la respuesta en responseText
                        switch (respuesta.responseText){
                            case "INCOK": //Todo correcto Usuario insertado y correo enviado
                                        salida.innerHTML = "<p class='ok'>Ya estas dado de alta revisa tu correo para activar tu cuenta</p>"
                                        break;
                            case "INCKO": //Se ha insertado en la bbdd pero el correo da fallo
                                        salida.innerHTML = "<p class='error'> No se ha podido enviar el correo a tu dirección con lo cual no podras hacer login</p>";
                                        break;
                            case "IN": //El correo se ha insertado correctamente
                            salida.innerHTML = "<p class='error'> No se ha podido enviar el correo a tu dirección con lo cual no podras hacer login</p>";                                        break;
                            case "EXISTE"://El usuario ya existe
                                        salida.innerHTML = "<p class='error'>El usuario ya existe en el sistema</p>";
                                        break;
                            //Solo para desarrollo
                            //default: salida.innerHTML = "<p>["+respuesta.responseText+"]</p>";
                        }
                    }else{
                        //No es 200 => 404 , 403 , etc
                    }
                    break;
        }
    }
    respuesta.open('POST',"../php/registro.php");
    respuesta.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    respuesta.send("user="+user.value+"&email="+email.value+"&pass="+pass.value);


}
