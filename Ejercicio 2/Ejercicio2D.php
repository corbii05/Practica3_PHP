<html>
<head>
    <meta charset="uft-8">
    <title>Resultado Dados</title>
</head>

<body>
    <h2>Ejercicio 2</h2>

<?php

// Variables
$total1 = 0;
$numero1 = 5;

print "<h2>Jugador 1</h2>";

// Bucle qeu repite 5 veces para simular 5 tiradas en el jugador 1
for ($i = 0; $i < $numero1; $i++) {

    //genera un número aleatorio 
    $dado1 = rand(1,6);

    //muestra la imagen según el número que ha salido en el dado
    print "<img src='./img/$dado1.jpg' height='140'>";

    // Suma el valor obtenido en la tirada del jugador 1
    $total1 = $total1 + $dado1;
}


// Genera lo mismo que lo anterior pero para el jugador 2
$total2 = 0;
$numero2 = 5;

print "<h2>Jugador 2 </h2>";

for ($i = 0; $i < $numero2; $i++) {

    $dado2 = rand(1,6);
    print "<img src='./img/$dado2.jpg' height='140'>";
    $total2 = $total2 + $dado2;
}

print "</p>";

// Condiciones

//Comprueba que la suma del jugador 1 sea mayor al del 2 para generar este comentario
if ($total1 > $total2) {
    print "Ha ganado el jugador 1.";
}
//Comprueba que la suma del jugador 2 sea mayor al del 1 para generar este comentario
if ($total2 > $total1) {
    print "Ha ganado el jugador 2.";
}
//Comprueba que la suma tanto del jugador 1 y 2 sea la misma para generar este comentario
if ($total1 == $total2) {
    print "Han quedado en empate.";
}
?>
</body>
</html>