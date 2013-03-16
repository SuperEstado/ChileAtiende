<div class="breadcrumb">
    <span>Wizard</span>
</div>

<div class="pane">
    

    <!-- tab "panes" -->
    <div class="panes">
        <div>
            <form name="paso01" method="post" action="backend/mantenimiento/wizard_paso01_path">
                <p>
                    Configuración general:<br />
                    se deben especificar los datos de entrada y salida para la creación de una DB limpia que contendrá:<br />
                    <ul>
                        <li>Datos XML desde ChileClic</li>
                        <li>Datos fichas ya diagramadas</li>
                    </ul>
                    El cual permitirá tener una versión limpia de ChileAtiende.
                </p>
                <br/>
                <div>
                    <!--<p>cargar zip <input type="file" name="chileclicZip" /></p>-->
                    <h3><b>Cargar XMLs desde ruta</b></h3>
                    <p> <input type="text" name="path" size="50" placeholder="/var/www/chileatiende/uploads/xml" /> ej: /var/www/chileatiende/uploads/xml</p>
                </div>
                <br/>
                <div>
                    <h3><b>Conexion</b></h3>
                    <p>usuario DB <input type="text" name="user" placeholder="Usuario DB" /></p>
                    <p>password DB <input type="password" name="pass" /></p>
                </div>

                <br/>
                <div>
                    <h3><b>Datos de origen</b></h3>
                    <p>nombre DB <input type="text" name="db_origen" placeholder="db_name_origen" /></p>
                </div>
                
                <br/>
                <div>
                    <h3><b>Datos de destino</b></h3>
                    <p>nombre DB <input type="text" name="db_destino" placeholder="db_name_destino" /></p>
                </div>
                
                <div>
                    <h3>Usuario</h3>
                    <p>Seleccione el usuario que aparecerá en el historial como el que realizó la creación de la ficha</p>
                    <p>
                        <select name="usuario" data-placeholder="Seleccione un usuario" class="chzn-select" style="width: 250px;">
                            <option value=""></option>
                            <?php
                            foreach ($usuarios as $usuario) {
                                echo '<option value="' . $usuario->id . '" >' . $usuario->nombres .' '. $usuario->apellidos . '</option>';
                            }
                            ?>
                        </select>
                    </p>
                </div>
                
                <div>
                    <h3>Institución</h3>
                    <p>Seleccione la institución que desea exportar</p>
                    <p>
                        <select name="institucion" data-placeholder="Seleccione una institución" class="chzn-select" style="width: 350px;">
                            <option value="">Todas</option>
                            <?php
                            foreach ($servicios as $servicio) {
                                echo '<option value="' . $servicio->codigo . '" >' . $servicio->nombre . '</option>';
                            }
                            ?>
                        </select>
                    </p>
                </div>

                <div>
                    <button type="submit">Yay!</button>
                </div>
            </form>
        </div>
        
    </div>
</div>