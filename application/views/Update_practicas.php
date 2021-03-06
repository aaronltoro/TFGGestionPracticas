<div>
    <!-- Nos traemos los datos de la practica a modificar, alumno, empresa, empleado, tutor_centro, las sedes de la empresa marcada por el select y todos los valores actuales de cada input-->
    <?php $practica = $this->prac; ?>
    <?php $alumno = $this->alumno; ?>
    <?php $empresa = $this->empresa; ?>
    <?php $empleado = $this->empleado; ?>
    <?php $tutor = $this->tutor; ?>
    <?php $sedesEmp = $this->sedesEmp; ?>
    <?php $valoresActuales = $this->valoresActuales; ?>

    <div class="row d-flex align-content-center justify-content-end">
        <div class="col-sm-1">
            <button class="btn btn-danger btn_exit" type="button" onclick="ir_practicas_view()"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
    <form id="modify_practica">

        <input type="hidden" id="idPracticaModificada" value='<?php echo $practica[0]['id'] ?>'>

        <div class="row">
            <div class="col-sm-1 offset-2 mt-3">
                <label for="idAlumno">Alumno: </label>
            </div>
            <div class="col-sm-7  mt-3">
                <select class="form-control" name="idAlumno" <?php echo count($alumno) == 0 ? 'id="alu_vacio"' : 'id="idAlumno"' ?>>
                    <?php if (count($alumno) == 0) { ?>
                        <option value="N/A">NO HAY ALUMNOS! PULSA PARA AÑADIR!</option>
                    <?php } else { ?>
                        <?php foreach ($alumno as $al) { ?>
                            <option value="<?php echo $al['id'] ?>" <?php if ($valoresActuales['idAlumno'] == null) {
                                                                        echo ($practica[0]['id_alumno'] == $al['id']) ? 'selected' : '';
                                                                    } else {
                                                                        echo ($valoresActuales['idAlumno'] == $al['id']) ? 'selected' : '';
                                                                    } ?>><?php echo $al['nombre'] ?></option>
                    <?php }
                    } ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-1 offset-2 mt-3">
                <label for="idEmpresa">Empresa: </label>
            </div>
            <div class="col-sm-7  mt-3">
                <select class="form-control" name="idEmpresa" <?php echo count($empresa) == 0 ? 'id="emp_vacia"' : 'id="idEmpresa"' ?>>
                    <?php if (count($empresa) == 0) { ?>
                        <option value="N/A">NO HAY EMPRESAS! PULSA PARA AÑADIR!</option>
                    <?php } else { ?>
                        <?php foreach ($empresa as $emp) { ?>
                            <option value="<?php echo $emp['id'] ?>" <?php if ($valoresActuales['idEmpresa'] == null) {
                                                                            echo ($practica[0]['id_empresa'] == $emp['id']) ? 'selected' : '';
                                                                        } else {
                                                                            echo ($emp['id'] == $sedesEmp[0]['id']) ? 'selected' : '';
                                                                        } ?>><?php echo $emp['nombre'] ?></option>
                    <?php }
                    } ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-1 offset-2 mt-3">
                <label for="sede">Sede: </label>
            </div>
            <div class="col-sm-7 mt-3">
                <select class="form-control" name="sede" id="sede">
                    <?php
                    //Separo el string direcciones en cada & y lo añado a un array de strings
                    $res_direcciones = explode('&', $sedesEmp[0]['direcciones']);

                    //Vuelvo a separar cada valor del array por cada = y así obtener su valor original y meto cada uno en el array $array_direcciones (quito los vacíos)
                    $count = 1;
                    $array_direcciones = array();
                    foreach ($res_direcciones as $key => $rd) {
                        if ($rd != '') {
                            $index = strval($count);
                            $valor = explode('=', $rd);
                            $count++;

                            foreach ($valor as $val) {
                                $array_direcciones['d' . $index] = $valor[1];
                            }
                        }
                    }

                    //Pinto los valores
                    if (count($array_direcciones) > 0) {
                        foreach ($array_direcciones as $dir) {
                    ?>
                            <option value="<?php echo $dir ?>"><?php echo $dir ?></option>
                        <?php
                        }
                    } else {
                        ?>
                        <option value="Sin Sede">Sin Sedes</option>
                    <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-1 offset-2 mt-3">
                <label for="idEmpleado">Empleado: </label>
            </div>
            <div class="col-sm-7  mt-3">
                <select class="form-control" name="idEmpleado" <?php echo count($empleado) == 0 ? 'id="empl_vacio"' : 'id="idEmpleado"' ?>>
                    <?php if (count($empleado) == 0) { ?>
                        <option value="N/A">NO HAY EMPLEADOS! PULSA PARA AÑADIR!</option>
                    <?php } else { ?>
                        <?php foreach ($empleado as $empl) { ?>
                            <option value="<?php echo $empl['id'] ?>" <?php if ($valoresActuales['idEmpleado'] == null) {
                                                                            echo ($practica[0]['id_empleado'] == $empl['id']) ? 'selected' : '';
                                                                        } else {
                                                                            echo ($valoresActuales['idEmpleado'] == $empl['id']) ? 'selected' : '';
                                                                        } ?>><?php echo $empl['nombre'] ?></option>
                    <?php }
                    } ?>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-1 offset-2 mt-3">
                <label for="idTutor">Tutor Centro: </label>
            </div>
            <div class="col-sm-7  mt-3">
                <select class="form-control" name="idTutor" <?php echo count($tutor) == 0 ? 'id="tut_vacio"' : 'id="idTutor"' ?>>
                    <?php if (count($tutor) == 0) { ?>
                        <option value="N/A">NO HAY TUTORES! PULSA PARA AÑADIR!</option>
                    <?php } else { ?>
                        <?php foreach ($tutor as $tut) { ?>
                            <option value="<?php echo $tut['id'] ?>" <?php if ($valoresActuales['idTutor'] == null) {
                                                                            echo ($practica[0]['id_tutor_centro'] == $tut['id']) ? 'selected' : '';
                                                                        } else {
                                                                            echo ($valoresActuales['idTutor'] == $tut['id']) ? 'selected' : '';
                                                                        } ?>><?php echo $tut['nombre'] ?></option>
                    <?php }
                    } ?>
                </select>
            </div>
        </div>

        <div class="row d-flex align-items-center">
            <div class="col-sm-2 d-flex align-items-center offset-3 mt-3 check_label">
                <input class="check_practica" id="check_activo" type="checkbox" <?php if ($valoresActuales['activo'] == null) {
                                                                                    echo ($practica[0]['seneca'] == 1) ? 'checked' : '';
                                                                                } else {
                                                                                    echo ($valoresActuales['activo'] == 1) ? 'checked' : '';
                                                                                } ?>>
                <label for="activo" style="margin:0">¿Alta en Séneca?</label>
            </div>
        </div>

        <div class="row d-flex align-items-center">
            <div class="col-sm-1 offset-2 mt-3">
                <label for="fecha_incorporacion" style="font-size: 14px">Fecha Incorporación:</label>
            </div>
            <div class="col-sm-2 mt-3">
                <input type="date" class="form-control" name="fecha_incorporacion" value='<?php if ($valoresActuales['fecha_incorporacion'] == null) {
                                                                                                echo $practica[0]['fecha_incorporacion'];
                                                                                            } else {
                                                                                                echo $valoresActuales['fecha_incorporacion'];
                                                                                            } ?>' />
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2 offset-5 mt-3 mb-3 d-flex justify-content-center">
                <button class="btn btn-warning btn_add" type="button" onclick="modify_practica(<?php echo $practica[0]['id'] ?>)">Modificar</button>
            </div>
        </div>
    </form>
</div>

<script>
    //Evento que redirige a la página de empresas al pulsar
    $('#alu_vacio').click(function() {
        ir_alumno_view();
    });
    //Evento que redirige a la página de empresas al pulsar
    $('#emp_vacia').click(function() {
        ir_empresa_view();
    });
    //Evento que redirige a la página de empresas al pulsar
    $('#empl_vacio').click(function() {
        ir_empleado_view();
    });
    //Evento que redirige a la página de empresas al pulsar
    $('#tut_vacio').click(function() {
        ir_tutor_centro_view();
    });

    //Cada vez que el usuario cambie el select de empresa se actualiza la página con las sedes de la empresa seleccionada
    $('#idEmpresa').change(function() {
        datas = $('#modify_practica').serialize();

        //Si el checkbox está marcado activo vale 1 y si no vale 0
        if (document.getElementById("check_activo").checked) {
            datas += '&activo=1';
        } else {
            datas += '&activo=0';
        }

        datas += '&idPracticaModificada=' + $('#idPracticaModificada').val();

        //Envío una función ajax al controlador con los valores del formulario y pinta la respuesta en el div #resultado
        $.ajax({
            type: "POST",
            url: BASE_URL + "Practicas_controller/load_modify",
            data: datas,
            success: function(data) {
                $("#resultado").html(data);
            },
        });
    })
</script>