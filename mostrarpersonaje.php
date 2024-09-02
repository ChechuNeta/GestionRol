<?php
// Cargar el archivo XML
$xml = simplexml_load_file('personaje.xml') or die("Error: No se puede cargar el archivo XML");

// Acceder al primer personaje
$personaje = $xml->personaje[0];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personaje</title>
    <link rel="stylesheet" href="css.css">
</head>
<body>

    <div id="encabezado">
        <h2 class="titulo"><?php echo $personaje->nombre; ?></h2>
        <p class="vida"><?php echo $personaje->puntosVida;?> / <?php echo $personaje->vida * 5;?></p>
    </div>

    <div id="contenedor">
        <div id="estadisticas">
            <p><strong>Fuerza:</strong> <?php echo $personaje->fuerza; ?></p>
            <p><strong>Destreza:</strong> <?php echo $personaje->destreza; ?></p>
            <p><strong>Vida:</strong> <?php echo $personaje->vida; ?></p>
            <p><strong>Inteligencia:</strong> <?php echo $personaje->inteligencia; ?></p>
            <p><strong>Carisma:</strong> <?php echo $personaje->carisma; ?></p>
            <p><strong>Velocidad:</strong> <?php echo $personaje->velocidad; ?></p>
            <p><strong>Nivel:</strong> <?php echo $personaje->nivel; ?></p>
            <button id="openEditStatsModal">Editar Estadísticas</button>
            <br><br>
            <h3>Talentos</h3>
            <ul>
                <?php foreach ($personaje->talentos->talento as $talento) : ?>
                    <li>
                        <strong><?php echo htmlspecialchars($talento->nombre); ?>:</strong> <?php echo htmlspecialchars($talento->descripcion); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div id="habilidades">
            <h3>Habilidades</h3>
            <ul>
                <?php foreach ($personaje->habilidades->habilidad as $habilidad) : ?>
                    <li>
                        <strong><?php echo htmlspecialchars($habilidad->nombre); ?>:</strong> <?php echo htmlspecialchars($habilidad->descripcion); ?> (Nivel <?php echo htmlspecialchars($habilidad->nivel); ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
            <br><br><br><br>
            <button id="openUsarModal">Usar objeto</button><br><br><br>
            <button id="usarHabilidadModal">Usar habilidad</button><br><br><br>
            <button id="usarMovimientoModal">Crear movimiento</button>

        </div>
    </div>

    <div id="contenedor2">
        <div id="objetos">
            <h3>Objetos</h3>
            <ul>
                <?php foreach ($personaje->objetos->objeto as $objeto) { 
                    if ($objeto->nombre == "Frasco con veneno" || $objeto->nombre == "Petaca de alcohol") {
                        ?>
                        <li>
                            <strong><?php echo htmlspecialchars($objeto->nombre); ?>: </strong> <?php echo htmlspecialchars($objeto->mililitros); ?> ml
                        </li>
                        <?php
                    } else {
                        ?>
                        <li>
                            <strong><?php echo htmlspecialchars($objeto->nombre); ?>: </strong><?php echo htmlspecialchars($objeto->cantidad); ?>
                        </li>
                        <?php
                    } 
                } ?>
            </ul>
        </div>

        <div id="movimientos">
            <h3>Movimientos</h3>
            <ul>
                
                <?php 
                $contador = count($personaje->movimientos->movimiento);
                for($i = $contador; $i > 0 ; $i--){ ?>
                    <li>
                        <?php echo htmlspecialchars($personaje->movimientos->movimiento[$i - 1]->descripcion); ?>
                    </li>
                <?php } ?>
            </ul>
        </div>


    </div>

    <div id="editStatsModal" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <h2>Editar Estadísticas</h2>
            <form id="editStatsForm" action="modificador.php" method="post">
                <label for="fuerza">Fuerza:</label>
                <input type="number" id="fuerza" name="fuerza" value="<?php echo $personaje->fuerza; ?>">
                <label for="destreza">Destreza:</label>
                <input type="number" id="destreza" name="destreza" value="<?php echo $personaje->destreza; ?>">
                <label for="vida">Vida:</label>
                <input type="number" id="vida" name="vida" value="<?php echo $personaje->vida; ?>">
                <label for="inteligencia">Inteligencia:</label>
                <input type="number" id="inteligencia" name="inteligencia" value="<?php echo $personaje->inteligencia; ?>">
                <label for="carisma">Carisma:</label>
                <input type="number" id="carisma" name="carisma" value="<?php echo $personaje->carisma; ?>">
                <label for="velocidad">Velocidad:</label>
                <input type="number" id="velocidad" name="velocidad" value="<?php echo $personaje->velocidad; ?>">
                <label for="nivel">Nivel:</label>
                <input type="number" id="nivel" name="nivel" value="<?php echo $personaje->nivel; ?>">
                <input type="submit" value="Guardar">
                <button type="button" class="modal-cancelBtn">Cancelar</button>
            </form>
        </div>
    </div>

    <div id="usarObjetoModal" class="usarobjetomodal">
        <div class="usarobjetomodal-content">
            <span class="usarobjetomodal-close">&times;</span>
            <h2>Usar Objeto</h2>
            <form action="modificador.php" method="post">

                <label for="objetoNombre">Objeto:</label>
                <?php
                    $nombresObjetosDeseados = ["Vendas", "Bala de Mecha", "Bengala", "Monedas de Oro", "Frasco con veneno", "Petaca de alcohol"];
                    ?>
                    <select name="objeto" id="objeto">
                        <?php foreach ($personaje->objetos->objeto as $objeto) : ?>
                            <?php if (in_array((string)$objeto->nombre, $nombresObjetosDeseados)) : ?>
                                <option value="<?php echo $objeto->id_objeto; ?>">
                                    <?php echo htmlspecialchars($objeto->nombre); ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                <br>
                <label for="dirigido">Aplica:</label>
                <label><input type="radio" id="yo" name="dirigido" value="Yo">Yo</label>
                <label><input type="radio" id="otro" name="dirigido" value="Otro">Otro</label>
                <br>
                <label for="cantidad">Si es otro, A quien:</label>
                <input type="text" name="destino">
                <br>
                <label for="cantidad">Cantidad:</label>
                <input type="number" value="1" name="cantidad">

                <input type="submit" value="Usar"/>
            </form>
        </div>
    </div>


    <div id="usarHabilidadModalDiv" class="modal-habilidad">
        <div class="modal-habilidad-content">
            <span class="modal-habilidad-close">&times;</span>
            <h2>Usar Habilidad</h2>
            <form id="usarHabilidadForm" action="modificador.php" method="post">
                <label for="habilidad">Habilidad</label>
                <select name="habilidad">
                    <?php
                    foreach($personaje->habilidades->habilidad as $lahabilidad)
                    {
                        ?><option value="<?php echo htmlspecialchars($lahabilidad->id_habilidad);?>"><?php echo htmlspecialchars($lahabilidad->nombre);?></option>
                        <?php
                    }
                    ?>
                </select>
                    <br>
                <label for="objetivo">Objetivo</label>
                <input type="text" name="objetivo">
                <br>
                <label for="daño">Daño realizado</label>
                <input type="number" name="daño">
                <br>
                <label for="cura">Cura realizada</label>
                <input type="number" name="cura">
                <br>
                <input type="submit" value="Usar">

            </form>
        </div>
    </div>


    
    <div id="crearMovimientoModal" class="modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <h2>Crear Movimiento</h2>
            <form id="crearMovimientoForm" action="modificador.php" method="post">

                <label for="daño">Daño recibido</label>
                <input type="number" name="danorec">
                <br>
                <label for="cura">Cura recibida</label>
                <input type="number" name="curarec">
                <br>
                <label for="desc">Descripcion</label>
                <input type="text" name="desc">
                <br>
                <input type="submit" value="Crear">

            </form>
        </div>
    </div>




    <script src="js.js"></script>
</body>
</html>
