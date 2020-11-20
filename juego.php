<!DOCTYPE html> 
<html> 
   <head> 
       <meta charset = "utf-8">
       <title>Siete y media</title>
   </head>

   <body> 
        <?php
        //Si no se introduce nombre se les otorga el nombre IA 1 e IA 2. 
        $jugador1 = $_GET['nombrejugador1'];
        if($jugador1 == null){
            $jugador1 = "IA 1";
        }
        $jugador2 = $_GET['nombrejugador2'];
        if($jugador2 == null){
            $jugador2 = "IA 2";
        }

        $limite1 = $_GET['comportamiento1'];
        $limite2 = $_GET['comportamiento2'];

        $puntuacion = 0;
        $puntuacion1 = 0;
        $puntuacion2 = 0;

        echo $jugador1 . " se enfrenta a " . $jugador2 . ".</br>";
        echo "Para decidir quien empieza a jugar se lanza una moneda al aire.</br>";

        // Elección de cara o cruz aleatoria
        $cara = rand(0, 1);
        if($cara == 0){
            echo $jugador1 .  " elige cara. " . $jugador2 . " elige cruz.";
        }else{
            echo $jugador2 .  " elige cara. " . $jugador1 . " elige cruz.";
        }

        //Lanzamiento de moneda aleatorio 
        $turno = rand(0, 1);
        if($turno == 0){
            echo " Se lanza la moneda y sale cara.";
        }else{
            echo " Se lanza la moneda y sale cruz.";
        }

        //Si jugador1 elige cara y sale cara o si jugador2 elige cara y sale cruz, empieza jugando el jugador1
        if(($cara == 0 && $turno == 0) || ($cara == 1 && $turno == 1)){
            echo " Empieza jugando " . $jugador1 . ".</br>";

            $puntuacion1 = jugador1($limite1, $puntuacion, $jugador1);
            //Si la puntuación supera 7.5 pierde, si iguala o supera el límite se planta, si no sigue jugando.
            if($puntuacion1 > 7.5){
                echo $jugador1 . " se ha pasado de 7.5 y ha perdido.</br>";
            }
            elseif($puntuacion1 >= $limite1){
                echo $jugador1 . " se planta.</br>";
            }else{
                echo " Sigue jugando.</br>";
            }

            //Si el jugador1 no ha perdido ya, si no se ha pasado de 7.5, el juego continúa y es el turno del jugador2
            if($puntuacion1 <= 7.5){
                //Le damos el valor de la puntuación que haya sacado el jugador1 a la variable limite2 para que el jugador2 siga sacando
                //cartas hasta que supere la puntuación del jugador1 o se pase de 7.5, para que no se plante con menos puntos de los que haya sacado el 
                //jugador1 básicamente porque no tendría sentido que hiciese eso.
                $limite2 = $puntuacion1;
                $puntuacion2 = jugador2($limite2, $puntuacion, $jugador2);
                if($puntuacion2 > 7.5){
                    echo $jugador2 . " se ha pasado de 7.5 y ha perdido.</br>";
                }
                elseif($puntuacion2 >= $limite2){
                    echo $jugador2 . " se planta.</br>";
                }else{
                    echo " Sigue jugando.</br>";
                }
            }

            //Si no ha empezado el jugador1 es porque empieza el jugador2
        }else{
            echo " Empieza jugando " . $jugador2 . ".</br>";
            $puntuacion2 = jugador2($limite2, $puntuacion, $jugador2);
            if($puntuacion2 > 7.5){
                echo $jugador2 . " se ha pasado de 7.5 y ha perdido.</br>";
            }
            elseif($puntuacion2 >= $limite2){
                echo $jugador2 . " se planta.</br>";
            }else{
                echo " Sigue jugando.</br>";
            }

            if($puntuacion2 <= 7.5){
                $limite1 = $puntuacion2;
                $puntuacion1 = jugador1($limite1, $puntuacion, $jugador1);   
                if($puntuacion1 > 7.5){
                    echo $jugador1 . " se ha pasado de 7.5 y ha perdido.</br>";
                }
                elseif($puntuacion1 >= $limite1){
                    echo $jugador1 . " se planta.</br>";
                }else{
                    echo " Sigue jugando.</br>";
                }   
            }
        }

        //Si alguno de los 2 jugadores se ha pasado de 7.5 gana su rival, si ninguno se pasa gana el que más puntos tenga y si ninguno tiene más puntos
        //que el otro es porque han empatado.
        if($puntuacion1 > 7.5){
            echo "Ha ganado " . $jugador2 . ".";
        }
        elseif($puntuacion2 > 7.5){
            echo "Ha ganado " . $jugador1 . ".";
        }
        elseif($puntuacion1 > $puntuacion2){
            echo $jugador1 . " tiene " . $puntuacion1 . " puntos. " . $jugador2 . " tiene " . $puntuacion2 . " puntos. Ha ganado " . $jugador1 . ".";
        }
        elseif($puntuacion1 < $puntuacion2){
            echo $jugador1 . " tiene " . $puntuacion1 . " puntos.  " . $jugador2 . " tiene " . $puntuacion2 . " puntos. Ha ganado  " . $jugador2 . ".";
        }else{
            echo $jugador1 . " tiene " . $puntuacion1 . " puntos.  " . $jugador2 . " tiene " . $puntuacion2 . " puntos. Ha habido un empate.";
        }


        function jugador1($limite1, $puntuacion, $jugador1){
            while($puntuacion < $limite1){
                $carta = rand(0, 7);

                $palo = array('bastos', 'copas', 'espadas','oros');
                $a = rand(0, 3);

                if($carta == 0){
                    $figura = array('la sota', 'el caballo', 'el rey');
                    $b = rand(0, 2);
                    echo $jugador1 . " ha robado " . $figura[$b] . " de " . $palo[$a] . ".";
                    $carta = 0.5;
                }else{
                    echo $jugador1 . " ha robado el $carta de " . $palo[$a] .  ".";
                }

                $puntuacion = $puntuacion + $carta;
                if($puntuacion == 0.5){
                    echo " Tiene medio punto.</br>";
                }
                elseif($puntuacion == 1){
                    echo " Tiene un punto.</br>";
                }
                elseif($puntuacion == 1.5){
                    echo " Tiene un punto y medio.</br>";
                }else{
                    echo " Tiene $puntuacion puntos.</br>";
                }
            }
            return $puntuacion;
        }

        function jugador2($limite2, $puntuacion, $jugador2){
            while($puntuacion < $limite2){
                $carta = rand(0, 7);

                $palo = array('bastos', 'copas', 'espadas','oros');
                $a = rand(0, 3);

                if($carta == 0){
                    $figura = array('la sota', 'el caballo', 'el rey');
                    $b = rand(0, 2);
                    echo $jugador2 . " ha robado " . $figura[$b] . " de " . $palo[$a] . ".";
                    $carta = 0.5;
                }else{
                    echo $jugador2 . " ha robado el $carta de " . $palo[$a] .  ".";
                }

                $puntuacion = $puntuacion + $carta;
                if($puntuacion == 0.5){
                    echo " Tiene medio punto.</br>";
                }
                elseif($puntuacion == 1){
                    echo " Tiene un punto.</br>";
                }
                elseif($puntuacion == 1.5){
                    echo " Tiene un punto y medio.</br>";
                }else{
                    echo " Tiene $puntuacion puntos.</br>";
                }
            }
            return $puntuacion;
        }
        ?>
        <form method="get"
                enctype="application/x-wwww-form-urlencoded"
                action="pantallainicio.html">

            <div><button type="submit">Volver a la pantalla de inicio</button></div>
        </form>
   </body> 
</html> 

