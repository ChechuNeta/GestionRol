<?php

$xmlFile = 'personaje.xml';
$xml = simplexml_load_file($xmlFile);
$personaje = $xml->personaje[0];

/***************************************** */
if (isset($_POST['fuerza'])) {
    $personaje->fuerza = $_POST['fuerza'];
    $personaje->destreza = $_POST['destreza'];
    $personaje->vida = $_POST['vida'];
    $personaje->inteligencia = $_POST['inteligencia'];
    $personaje->carisma = $_POST['carisma'];
    $personaje->velocidad = $_POST['velocidad'];
    $personaje->nivel = $_POST['nivel'];

    $xml->asXML($xmlFile);
    header("Location: mostrarpersonaje.php");
    exit();
}

/************************************************ */
if (isset($_POST['objeto'])) {
    if ((int)$_POST['objeto'] == 7 && $_POST['dirigido'] == "Yo") {
        $antiguavida = (int)$personaje->puntosVida;
        $personaje->puntosVida += (75 * (int)$_POST['cantidad']);
        if ($personaje->puntosVida > $personaje->vida * 5) {
            $personaje->puntosVida = $personaje->vida * 5;
        }
        $nuevavida = (int)$personaje->puntosVida;
        $vidasumada = $nuevavida - $antiguavida;
    }

    foreach ($personaje->objetos->objeto as $objeto) {
        if ((int)$objeto->id_objeto == (int)$_POST['objeto']) {
            if ((int)$objeto->id_objeto == 5 || (int)$objeto->id_objeto == 8) {
                $objeto->mililitros = $objeto->mililitros - (int)$_POST['cantidad'];
            } else {
                $objeto->cantidad = $objeto->cantidad - (int)$_POST['cantidad'];
            }
            if ($objeto->cantidad < 0 || $objeto->mililitros < 0) {
                $objeto->cantidad = 0;
                $objeto->mililitros = 0;
            }

            break;
        }
    }

    $nuevoMovimiento = $personaje->movimientos->addChild('movimiento');
    $nuevoMovimiento->addChild('id_movimiento', count($personaje->movimientos->movimiento) + 1);
    switch ($_POST['objeto']) {
        case 1:
            $nuevoMovimiento->addChild('origen', "Orwhan");
            $nuevoMovimiento->addChild('destino', "Orwhan");
            $nuevoMovimiento->addChild('descripcion', "Orwhan ha usado " . $_POST['cantidad'] . " Balas de mecha para multiplicar su daño");
            break;

        case 2:
            $nuevoMovimiento->addChild('origen', "Orwhan");
            if ($_POST['dirigido'] != "Yo") {
                $nuevoMovimiento->addChild('destino', $_POST['destino']);
                $nuevoMovimiento->addChild('descripcion', "Orwhan ha entregado una bengala a " . $_POST['destino']);
            } else {
                $nuevoMovimiento->addChild('destino', "Orwhan");
                $nuevoMovimiento->addChild('descripcion', "Orwhan ha usado una bengala");
            }
            break;

        case 5:
            $nuevoMovimiento->addChild('origen', "Orwhan");
            $nuevoMovimiento->addChild('destino', "Orwhan");
            $nuevoMovimiento->addChild('descripcion', "Orwhan ha usado " . $_POST['cantidad'] . "ml de alcohol de su petaca");
            break;

        case 6:
            $nuevoMovimiento->addChild('origen', "Orwhan");
            $nuevoMovimiento->addChild('destino', "Orwhan");
            $nuevoMovimiento->addChild('descripcion', "Orwhan ha gastado " . $_POST['cantidad'] . " monedas de oro");
            break;

        case 7:
            $nuevoMovimiento->addChild('origen', "Orwhan");
            if ($_POST['dirigido'] != "Yo") {
                $nuevoMovimiento->addChild('destino', $_POST['destino']);
                $nuevoMovimiento->addChild('descripcion', "Orwhan ha entregado " . $_POST['cantidad'] . " venda/s a " . $_POST['destino']);
            } else {
                $nuevoMovimiento->addChild('destino', "Orwhan");
                $nuevoMovimiento->addChild('descripcion', "Orwhan ha usado " . $_POST['cantidad'] . " venda/s y se ha curado " . $vidasumada . " puntos de vida");
            }
            break;

        case 8:
            $nuevoMovimiento->addChild('origen', "Orwhan");
            $nuevoMovimiento->addChild('destino', "Orwhan");
            $nuevoMovimiento->addChild('descripcion', "Orwhan ha usado " . $_POST['cantidad'] . "ml de veneno de su frasco");
            break;
    }

    $xml->asXML($xmlFile);
    header("Location: mostrarpersonaje.php");
    exit();
}

/************************************************ */

if(isset($_POST['habilidad']))
{

    $nuevoMovimiento = $personaje->movimientos->addChild('movimiento');
    $nuevoMovimiento->addChild('id_movimiento', count($personaje->movimientos->movimiento) + 1);
    $hab = (int)$_POST['habilidad'];
    switch($hab)
    {
        case 1:
            $nuevoMovimiento->addChild('origen', "Orwhan");
            $nuevoMovimiento->addChild('destino', $_POST['objetivo']);
            $nuevoMovimiento->addChild('daño_realizado', $_POST['daño']);
            $nuevoMovimiento->addChild('descripcion', "Orwhan ha usado " . $personaje->habilidades->habilidad[$hab - 1]->nombre . " contra " . $_POST['objetivo'] . " y causa " . $_POST['daño'] . " de daño");
            break;

        case 2:
            $nuevoMovimiento->addChild('origen', "Orwhan");
            $nuevoMovimiento->addChild('destino', $_POST['objetivo']);
            $nuevoMovimiento->addChild('daño_realizado', $_POST['cura']);
            
            if($_POST['objetivo'] == "Orwhan")
            {
                $laantiguavida = (int)$personaje->puntosVida;
                $personaje->puntosVida += (int)$_POST['cura'];
                if ($personaje->puntosVida > $personaje->vida * 5) {
                    $personaje->puntosVida = $personaje->vida * 5;
                }
                $lanuevavida = (int)$personaje->puntosVida;
                $lavidasumada = $lanuevavida - $laantiguavida;
                $nuevoMovimiento->addChild('descripcion', "Orwhan ha usado " . $personaje->habilidades->habilidad[$hab - 1]->nombre . " para curarse " . $lavidasumada . " de vida");
            }
            else
            {
                $nuevoMovimiento->addChild('descripcion', "Orwhan ha usado " . $personaje->habilidades->habilidad[$hab - 1]->nombre . " contra " . $_POST['objetivo'] . " y le cura " . $_POST['cura'] . " de vida");
            }

            break;

        case 3:
            $nuevoMovimiento->addChild('origen', "Orwhan");
            $nuevoMovimiento->addChild('destino', $_POST['objetivo']);
            $nuevoMovimiento->addChild('descripcion', "Orwhan ha usado " . $personaje->habilidades->habilidad[$hab - 1]->nombre . " se oculta del campo de vision por un turno");
            break;
    }

    $xml->asXML($xmlFile);
    header("Location: mostrarpersonaje.php");
    exit();
}

if(isset($_POST['desc']))
{
    $nuevoMovimiento = $personaje->movimientos->addChild('movimiento');
    $nuevoMovimiento->addChild('id_movimiento', count($personaje->movimientos->movimiento) + 1);

    $dañoRecibido = isset($_POST['danorec']) ? (int)$_POST['danorec'] : 0;
    $curaRecibida = isset($_POST['curarec']) ? (int)$_POST['curarec'] : 0;
    $descripcion = isset($_POST['desc']) ? htmlspecialchars($_POST['desc']) : '';

    if ($dañoRecibido > 0) {
        $antiguavida = (int)$personaje->puntosVida;
        $personaje->puntosVida -= $dañoRecibido;
        if ($personaje->puntosVida < 0) {
            $personaje->puntosVida = 0;
        }
        $nuevaVida = (int)$personaje->puntosVida;
        $daño = $antiguavida - $nuevaVida;

        $nuevoMovimiento->addChild('daño_recibido', $dañoRecibido);
        $nuevoMovimiento->addChild('descripcion', "Orwhan ha recibido $daño puntos de daño por $descripcion");
    } elseif ($curaRecibida > 0) {
        $antiguavida = (int)$personaje->puntosVida;
        $personaje->puntosVida += $curaRecibida;
        if ($personaje->puntosVida > $personaje->vida * 5) {
            $personaje->puntosVida = $personaje->vida * 5;
        }
        $nuevaVida = (int)$personaje->puntosVida;
        $cura = $nuevaVida - $antiguavida;

        $nuevoMovimiento->addChild('cura_recibida', $curaRecibida);
        $nuevoMovimiento->addChild('descripcion', "Orwhan ha recibido $cura puntos de vida por $descripcion");
    } else {
        $nuevoMovimiento->addChild('descripcion', $descripcion);
    }

    $xml->asXML($xmlFile);
    header("Location: mostrarpersonaje.php");
    exit();

}


?>









