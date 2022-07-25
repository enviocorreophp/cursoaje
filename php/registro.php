<?php
    //Importamos el archivo de configuracion
    require_once 'config.php';
    //Verificamos si venimos del formulario
    if (isset($_POST['user']) && isset($_POST['email']) && isset ($_POST['pass'])){
        //Venimos del POST
        //Definimos las variables que nos llegan por POST
        $user = $_POST['user'];
        $pass = md5($_POST['pass']);
        $email = $_POST['email'];
        $verificacion = md5($email."palabrapaso");
        //Liberamos la memoria de $_POST
        unset($_POST);
        //Comprobamos en la bbdd a ver si ya existe el usuario
        try{
            if ($conexion = new PDO($bbdd,$dbuser,$dbpass)){
                //LA conexion se realiza correctamente
                //Realizamos la consulta de ver si esta el usuario
                $consulta = $conexion->prepare("SELECT id FROM usuarios WHERE usuario=:u");
                //Preparo los parametros
                $consulta->bindParam(':u',$user);
                if ($consulta->execute()){
                    //Se ha realizado la consulta
                    if ($consulta->rowCount()){
                        //Cerrar la consulta
                        $consulta->closeCursor();
                        //El usuario ya existe
                        echo "EXISTE";
                    }else{
                        //El usuario no existe
                        $consulta->closeCursor();
                        //Entonces lo insertamos
                        //Controlo los errores de la inserccion
                        try{
                            //Preparamos la consulta de la insercion
                            $consulta = $conexion->prepare("INSERT INTO usuarios (usuario,pass,email,verificacion,validado) VALUES (:u,:p ,:e,:v,0)");
                            //al principio del registro todos los usuarios no estan validados por eso se mete un 0= false directamente
                            $consulta->bindParam(':u',$user);
                            $consulta->bindParam(':p',$pass);
                            $consulta->bindParam(':e',$email);
                            $consulta->bindParam(':v',$verificacion);
                            //Y ya podemos ejecutar la sentencia
                            if ($consulta->execute()){
                                //La consulta es correcta
                                //Para que la insercion de 1 fila sea correcta rowCout debe ser 1
                                if ($consulta->rowCount()){
                                    //PERFECTO!!!! Se ha insertado correctamente
                                    echo "IN"; 
                                    //Entoncess podemos enviarle un correo
                                    //Esta vez usamos un include para la libreria del correo
                                    //puesto que no queremos que falle el respo por problemas
                                    //en el envio de correo
                                    include_once 'enviocorreo.php';
                                    //enviarCorreo devuelve true si todo ha sido correcto y false si tenemos problemas
                                    if (enviarCorreo($user,$email,$verificacion)){
                                        //El correo se ha enviado correctamente
                                        echo "COK";
                                    }else echo "CKO";
                                    
                                }
                            }else{
                                //La consulta es incorrecta
                            }

                        }catch(PDOException $ei){
                            //Error grave pero en la inserccion
                        }

                    }
                }else{
                    //Fallos en la consulta
                }
                //Cerramos la conexion
                unset($conexion);
            }else{
                //Falla la conexion
            }
        }catch(PDOException $e){
            //Errores grave de la BBDD
        }
    }else{
        //Nos sabiamos la URL
        header("Location:{$site}registro.html");
    }


?>