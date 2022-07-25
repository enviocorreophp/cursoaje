<?php
//Este fichero se encarga de realizar la activacion de una cuenta
//cuando el usuario pincha en verficar cuenta del correo mandado 
//en el registro
require_once 'config.php';

//verificar que este fichero recibe datos mediante get
if (isset($_GET['u'])){
    //Entonces se han ecbido datos por GET
    //intentamos poner su estado a de verificado a 1
    try{
        //Actualizamos el usuario
        if ($conexion = new PDO($bbdd,$dbuser,$dbpass)){
            //La conexion se ha realizado correctamente
            $consulta = $conexion->prepare("UPDATE usuarios SET validado=1 WHERE verificacion=:v");
            //Preparamos los parametros
            $consulta->bindParam(':v',$_GET['u']);
            //ejecutamos la sentencia
            if ($consulta->execute()){
                //Todo correcto
                if ($consulta->rowCount()){
                    //Al menos una fila ha sido afectada
                    echo "
                    <div style='background-color: lightgreen; margin:2rem; border-radius:20px'>
                    <p style='text-align:center; color:green; padding:5rem'>
                        <svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-circle-check' width='44' height='44' viewBox='0 0 24 24' stroke-width='1.5' stroke='#2c3e50' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                    <path stroke='none' d='M0 0h24v24H0z' fill='none'/>
                    <circle cx='12' cy='12' r='9' />
                    <path d='M9 12l2 2l4 -4' /> 
                  </svg>
                  Tu usuario ha sido verificado correctamente</p>
                    </div>
                    <script>
                    setTimeout(function(){
                        window.location.href = '../index.html';
                    },5000);
                    </script>
                    ";
                }else{
                    //Este usuario no existe

                }
            }else{
                //Fallo en la consulta
            }
            //cerramos la consulta
            $consulta->closeCursor();
            //cerramos la conexion
            unset($conexion);
        }
    }catch(PDOException $e){
        //Por si queremos hacer algo con la excepcion
    }

}else{
    //Hemos llegado a este recurso porque sabiamos la URL
    header("Location:{$site}index.html");
}
?>