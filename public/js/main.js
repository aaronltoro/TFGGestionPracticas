function ir_principal_view(){
    //Vuelve a la página principal
    window.history.back();
}

function ir_empresa_view(){
    //Envío una función ajax para ir al archivo Empresa_view.php
    $.ajax({
        type: "POST",
        url: BASE_URL + 'Principal_controller/ir_empresa_view',
        data: null,
        success: function (data) {
            $('#res_principal').html(data);
        }
    });

    //Cargo la tabla con todos los registros de la base de datos al cargar la página Empresa_view.php
    carga_empresa();
}


function ir_alumno_view(){
    //Envío una función ajax para ir al archivo Empresa_view.php
    $.ajax({
        type: "POST",
        url: BASE_URL + 'Principal_controller/ir_alumno_view',
        data: null,
        success: function (data) {
            $('#res_principal').html(data);
        }
    });

    //Cargo la tabla con todos los registros de la base de datos al cargar la página Empresa_view.php
    carga_alumnos();
}

function carga_empresa() {
    //Envío una función ajax al cargar la página para que me pinte la tabla con todos sus campos
    $.ajax({
        type: "POST",
        url: BASE_URL + 'Empresa_controller/tabla_ini',
        data: null,
        success: function (data) {
            $('#resultado').html(data);
        }
    });
}

function carga_alumnos() {
    //Envío una función ajax al cargar la página para que me pinte la tabla con todos sus campos
    $.ajax({
        type: "POST",
        url: BASE_URL + 'Alumno_controller/tabla_ini',
        data: null,
        success: function (data) {
            $('#resultado').html(data);
        }
    });
}

function carga_filtros_empresa() {
    // Traigo todos los filtros seleccionados en cada input
    filters = $('#filtros_empresa').serialize();

    //Envío una función ajax al controlador con los valores del formulario y pinta la respuesta en el div #resultado
    $.ajax({
        type: "POST",
        url: BASE_URL + 'Empresa_controller/search_filters',
        data: filters,
        success: function (data) {
            $('#resultado').html(data);
        }
    });
}

function carga_filtros_alumno() {
    // Traigo todos los filtros seleccionados en cada input
    filters = $('#filtros_alumno').serialize();

    //Envío una función ajax al controlador con los valores del formulario y pinta la respuesta en el div #resultado
    $.ajax({
        type: "POST",
        url: BASE_URL + 'Alumno_controller/search_filters',
        data: filters,
        success: function (data) {
            $('#resultado').html(data);
        }
    });
}

function carga_insert_empresa() {
    //Envío una función ajax al controlador para pintar el formulario de insert
    $.ajax({
        type: "POST",
        url: BASE_URL + 'Empresa_controller/load_insert',
        data: null,
        success: function (data) {
            $('#resultado').html(data);
        }
    });
}

function carga_insert_alumno() {
    //Envío una función ajax al controlador para pintar el formulario de insert
    $.ajax({
        type: "POST",
        url: BASE_URL + 'Alumno_controller/load_insert',
        data: null,
        success: function (data) {
            $('#resultado').html(data);
        }
    });
}

function add_empresa() {
    // Traigo todos los datos seleccionados en cada input
    datas = $('#insert_empresa').serialize();

    //Compruebo cuantos inputs de direcciones contiene la variable datas
    nsedes = 0;
    if(datas.includes('direccion1')){
        nsedes = 1;
    }
    if(datas.includes('direccion2')){
        nsedes = 2;
    }
    if(datas.includes('direccion3')){
        nsedes = 3;
    }
    if(datas.includes('direccion4')){
        nsedes = 4;
    }
    if(datas.includes('direccion5')){
        nsedes = 5;
    }
    if(datas.includes('direccion6')){
        nsedes = 6;
    }
    if(datas.includes('direccion7')){
        nsedes = 7;
    }

    //Añado el nsedes al string datas para poder recogerlo luego en el controller
    datas += '&nsedes=' + nsedes;

    //Envío una función ajax al controlador con los valores del formulario y pinta la respuesta en el div #resultado
    $.ajax({
        type: "POST",
        url: BASE_URL + 'Empresa_controller/add_empresa',
        data: datas,
        success: function (data) {
            $('#resultado').html(data);
        }
    });
}


function add_alumno() {
    // Traigo todos los datos seleccionados en cada input
    datas = $('#insert_alumno').serialize();

    //Envío una función ajax al controlador con los valores del formulario y pinta la respuesta en el div #resultado
    $.ajax({
        type: "POST",
        url: BASE_URL + 'Alumno_controller/add_alumno',
        data: datas,
        success: function (data) {
            $('#resultado').html(data);
        }
    });
}


function carga_modify_empresa(id) {
    //Envío una función ajax al controlador para pintar el formulario de modify además del id de la fila
    $.ajax({
        type: "POST",
        url: BASE_URL + 'Empresa_controller/load_modify',
        data: { id: id },
        success: function (data) {
            $('#resultado').html(data);
        }
    });
}

function carga_modify_alumno(id) {
    //Envío una función ajax al controlador para pintar el formulario de modify además del id de la fila
    $.ajax({
        type: "POST",
        url: BASE_URL + 'Alumno_controller/load_modify',
        data: { id: id },
        success: function (data) {
            $('#resultado').html(data);
        }
    });
}


function modify_alumno(id) {
    // Traigo todos los datos seleccionados en cada input
    datas = $('#modify_alumno').serialize();

    //Añado el id de la fila al string datas para poder recogerlo luego en el controller
    datas += '&id=' + id;

    //Envío una función ajax al controlador con los valores del formulario y pinta la respuesta en el div #resultado
    $.ajax({
        type: "POST",
        url: BASE_URL + 'Alumno_controller/modify_alumno',
        data: datas,
        success: function (data) {
            $('#resultado').html(data);
        }
    });
}

function modify_empresa(id) {
    // Traigo todos los datos seleccionados en cada input
    datas = $('#modify_empresa').serialize();

    //Compruebo cuantos inputs de direcciones contiene la variable datas
    nsedes = 0;
    if(datas.includes('direccion1')){
        nsedes = 1;
    }
    if(datas.includes('direccion2')){
        nsedes = 2;
    }
    if(datas.includes('direccion3')){
        nsedes = 3;
    }
    if(datas.includes('direccion4')){
        nsedes = 4;
    }
    if(datas.includes('direccion5')){
        nsedes = 5;
    }
    if(datas.includes('direccion6')){
        nsedes = 6;
    }
    if(datas.includes('direccion7')){
        nsedes = 7;
    }

    //Añado el nsedes al string datas para poder recogerlo luego en el controller
    datas += '&nsedes=' + nsedes;

    //Añado el id de la fila al string datas para poder recogerlo luego en el controller
    datas += '&id=' + id;

    //Envío una función ajax al controlador con los valores del formulario y pinta la respuesta en el div #resultado
    $.ajax({
        type: "POST",
        url: BASE_URL + 'Empresa_controller/modify_empresa',
        data: datas,
        success: function (data) {
            $('#resultado').html(data);
        }
    });
}

function delete_empresa(id) {
    $borra = confirm('¿Estás seguro de que deseas borrar el campo seleccionado? [' + id + ']');
    //Si el usuario pulsa en aceptar...
    if ($borra) {
        //Envío una función ajax al controlador con el id de la fila seleccionada
        $.ajax({
            type: "POST",
            url: BASE_URL + 'Empresa_controller/delete_empresa',
            data: { id: id },
            success: function (data) {
                $('#resultado').html(data);
            }
        });
    }
}

function delete_alumno(id) {
    $borra = confirm('¿Estás seguro de que deseas borrar el campo seleccionado? [' + id + ']');
    //Si el usuario pulsa en aceptar...
    if ($borra) {
        //Envío una función ajax al controlador con el id de la fila seleccionada
        $.ajax({
            type: "POST",
            url: BASE_URL + 'Alumno_controller/delete_alumno',
            data: { id: id },
            success: function (data) {
                $('#resultado').html(data);
            }
        });
    }
}

function eliminar_sede(id,id_empresa){
    // Traigo todos los datos seleccionados en cada input
    datas = $('#modify_empresa').serializeArray();

    //Guardo en la variable elim el valor del input que se ha pulsado para borrar
    elim = 0;
    for(i in datas){
        if(datas[i].name.includes(id)){
            elim = i;
        }
    }

    //Borro el campo del array seleccionado
    datas.splice(elim,1);

    //Cambio el nombre a los siguientes campos, restando 1
    cont = -1;
    for(i in datas){
        if(i >= elim){
            datas[i].name = "direccion"+cont;
        }
        cont++;
    }

    //Elimino el div del botón pulsado
    $('#div_direccion'+id).hide();

    //Compruebo cuantos inputs de direcciones contiene la variable datas
    nsedes = cont-1;

    //Añado el nsedes al string datas para poder recogerlo luego en el controller
    datas.push({name: 'nsedes', value: nsedes});

    //Inserto el id de la empresa que vamos a updatear
    datas.push({name: 'id', value: id_empresa});

    //Envío una función ajax al controlador con los valores del formulario y pinta la respuesta en el div #resultado
    $.ajax({
        type: "POST",
        url: BASE_URL + 'Empresa_controller/modify_sede',
        data: datas,
        success: function (data) {
            $('#resultado').html(data);
        }
    });
}