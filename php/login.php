<?php
    sleep(2);
    
    //importo el archivo de configuracion con los parametros de la pagina
    require_once 'config.php';
    //Si llegamos a este documento porque sabiamos la URL entonces 
    //hay que volver al formulario de login
    if (isset($_POST['user']) && isset($_POST['pass'])){
        //Nos ha llegado datos desde el login
        //Ya podemos verificar a este usuario en la bbdd
        $user = $_POST['user'];
        $pass = md5($_POST['pass']);
        //Libero memoria de $_POST
        unset($_POST);
        //Realizamos conexion con la bbdd
        try{
            if ($conexion = new PDO($bbdd,$dbuser,$dbpass)){
                //La asignación se ha realizado correctamente
                //Ahora podemos hacer la consulta
                $consulta = $conexion->prepare("SELECT id FROM usuarios where usuario=:u AND pass=:p");
                //Preparamos los parametros
                $consulta->bindParam(':u',$user);
                $consulta->bindParam(':p',$pass);
                //Ejecutamos la consulta
                if ($consulta->execute()){
                    //La consulta se ha realizado correctamente
                    //Podemos tener o 0 filas (no esta en la bbdd el usuario)
                    //o al menos 1 fila (el usuario si esta en la bbdd)
                    if ($consulta->rowCount()){
                        //Tenemos al menos 1 fila
                        //Preparo las sesiones
                        session_name('JCN');
                        session_start();
                        $_SESSION['user']=$user;
                        echo "OK";
                    }else{
                        //No tenemos filas => el usuario no esta
                        echo "KO";
                    }
                }else{
                    //Problemas con la consulta
                    echo "ERRC"; //Error consulta
                }
            }else{
                //Problema al hacer la conexion
                echo "ERRCO"; //Error de conexion
            }
        }catch(PDOException $e){
            //Si sucede un error con la conexion con la bbdd
            echo "ERROR"; //Error con la BBDD general
        }

    }else{
        //Sabiamos la url
        header("Location:{$site}index.html");
    }

?>