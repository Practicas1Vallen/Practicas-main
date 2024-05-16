//EDITADO

function filtra_despachos(){
	var url 			= $("#btn_filtrar").attr("url");
	var fecha_inicial 	= $("#fecha_inicial").val()||"";
	var fecha_final 	= $("#fecha_final").val()||"";

	if (fecha_inicial == ""){
        $.alert({
            title: 'Alerta',
            content: "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Selecciona la fecha inicial.",
            confirmButtonClass: "btn-success"
        });
        return false;
    }
	if (fecha_final == ""){
        $.alert({
            title: 'Alerta',
            content: "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Selecciona la fecha final.",
            confirmButtonClass: "btn-success"
        });
        return false;
    }

	$("#btn_filtrar").attr("disabled",true);
    $("#btn_filtrar").html("Filtrando <i class='fa fa-refresh fa-spin' aria-hidden='true'></i>");

    tabla_sup.data();
    tabla_sup.clear();
    tabla_sup.draw();  

    $.ajax({
        dataType: "json",
        type: "POST",
        timeout: 50000,
        data: {fecha_inicial: fecha_inicial,fecha_final:fecha_final},
        url: url,
        success: function(data) {
            if (data.EVENTO == 'OK') {
            	if(data.TABLA!=""){
                    console.log(data)
                    $.each(data.TABLA, function(i,item){                       
                        var FECHA=item.FECHA||0,
                            ESTATUS=item.ESTATUS||'',
                            FOLIO=item.FOLIO||'';
                            REQUISICION_ID=item.REQUISICION_ID||'';
                            ENVIO_AUTORIZACION=item.ENVIO_AUTORIZACION||'';
                        
                        newRowSup = tabla_sup.row.add([
                            FOLIO,
                            FECHA,
                            '<label class="badge badge-info">'+ESTATUS+'</label>',
                            '<button class="btn btn-warning" id="btn_detalle'+REQUISICION_ID+'" onclick="javascript:detalle_cotizacion_pendiente('+REQUISICION_ID+','+ENVIO_AUTORIZACION+');"><i class="fa fa-edit"></i></button>'
                            
                        ]).draw(false).node();

                        $(newRowSup).eq(0);
                        $("td:eq(0)", newRowSup).addClass('v-align-middle');
                        $("td:eq(1)", newRowSup).addClass('v-align-middle');
                        $("td:eq(2)", newRowSup).addClass('v-align-middle');
                        $("td:eq(3)", newRowSup).addClass('v-align-middle');
                        $("td:eq(4)", newRowSup).addClass('v-align-middle');
                        $("td:eq(5)", newRowSup).addClass('v-align-middle');
                        $("td:eq(6)", newRowSup).addClass('v-align-middle');
                        $("td:eq(7)", newRowSup).addClass('v-align-middle');
                        $("td:eq(8)", newRowSup).addClass('v-align-middle');
                        $("td:eq(9)", newRowSup).addClass('v-align-middle');

					    $("#btn_filtrar").removeAttr("disabled");
					    $("#btn_filtrar").html("Filtrar <i class='fa fa-filter' aria-hidden='true'></i>");

                    });
                }
                
            } else if (data.EVENTO == 'NOT_SESSION') {
                window.location.replace(url_root + "?qs=login");
            } else {
			    $("#btn_filtrar").removeAttr("disabled");
			    $("#btn_filtrar").html("Filtrar <i class='fa fa-filter' aria-hidden='true'></i>");

                $.alert({
                    title: 'Error',
                    content: "<i class='fa fa-times-circle' aria-hidden='true'></i> No se pudo completar tu solicitud, por favor inténtalo más tarde.",
                    confirmButtonClass: "btn-success"
                });
            }
        },
        error: function(xhr, status, error) {
		    $("#btn_filtrar").removeAttr("disabled");
		    $("#btn_filtrar").html("Filtrar <i class='fa fa-filter' aria-hidden='true'></i>");

            $.alert({
                title: 'Error',
                content: "<i class='fa fa-times-circle' aria-hidden='true'></i> Se perdio la conexión con el servidor, por favor inténtalo más tarde.",
                confirmButtonClass: "btn-success"
            });
        }
    })
}



//**********************ESTO ES EN FUNCION A LAS REQUISICIONES (NO SE USA)*****************************************/

/*function detalle_req(requisicion_id,envio_autorizacion) {
    var url = $("#form-cotizador").attr("url_detalle");
    var url_root = $("#menu_top").attr("url_root");

    $("#btn_detalle"+requisicion_id).attr("disabled",true);
    $("#btn_detalle"+requisicion_id).html("<i class='fa fa-refresh fa-spin' aria-hidden='true'></i>");

    $.ajax({
        dataType:"json",
        type:"POST",
        data:{requisicion_id:requisicion_id,envio_autorizacion:envio_autorizacion,codigo_aut:codigo_aut},
        url: url,
        timeout:3000,
        success: function(data){
            if(data.EVENTO == "OK"){
                $("#btn_detalle"+requisicion_id).removeAttr("disabled");
                $("#btn_detalle"+requisicion_id).html("<i class='fa fa-edit' aria-hidden='true'></i>");
                $("#tbody_detalle").html(data.LISTA_DETALLE);
                $("#footer_modal").html(data.BOTONES_MODAL);
                $("#area_comentarios").html(data.AREA_COMENTARIOS);
                $("#modal_detalle").modal();
            }
            if(data.EVENTO == "ERROR"){
                $("#btn_detalle"+requisicion_id).removeAttr("disabled");
                $("#btn_detalle"+requisicion_id).html("<i class='fa fa-edit' aria-hidden='true'></i>");

                $.alert({
                    title: 'Alerta',
                    content: "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Ocurrió un error por favor intentalo más tarde.",
                    confirmButtonClass:"btn-success"
                });
                return false;
            }
        },error: function(xhr,status,error){
            $("#btn_detalle"+requisicion_id).removeAttr("disabled");
            $("#btn_detalle"+requisicion_id).html("<i class='fa fa-edit' aria-hidden='true'></i>");
        }
    })
}

function autoriza_req(requisicion_id,usuario_id){
    var url_root = $("#menu_top").attr("url_root");
    var partidas = "";
    var codigo_aut = $("#codigo_aut").val()||"";

    var check = document.getElementsByName("selecciona_cot");
    for (var x = 0; x < check.length; x++) {
        if(check[x].checked){
            partidas += check[x].value+'-'+check[x].getAttribute('cantidad')+",";
        }
    }
    if (partidas == ""){
        $.alert({
            title: 'Alerta',
            content: "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Selecciona las partidas.",
            confirmButtonClass:"btn-success"
        });
        return false;
    }

    var array_partidas = partidas.slice(0,-1);

    if (codigo_aut == ""){
        $.alert({
            title: 'Alerta',
            content: "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Ingresa el código de autorización.",
            confirmButtonClass:"btn-success"
        });
        return false;
    }

    $("#btn_aut"+requisicion_id).attr("disabled",true);
    $("#btn_aut"+requisicion_id).html("Procesando <i class='fa fa-refresh fa-spin'></i>");

    $.ajax({
        url: "https://maps-norte.vallen.com.mx/maps/pullticket/autorizarreqoc.php",
        data: { REQUISICION_ID:requisicion_id,PARTIDAS:array_partidas,CODIGO_AUT:codigo_aut,USUARIO_ID:usuario_id  },
        type: 'get',
        dataType: 'jsonp',
        callbackParameter: 'callback',
        success: function(data_json) {
            $.each(data_json, function(i, item) {
                var RESULTADO = item.RESULTADO || 0;
                if (RESULTADO == 1) {
                    $("#btn_aut"+requisicion_id).removeAttr("disabled");
                    $("#btn_aut"+requisicion_id).html("Autorizar");
                    $("#modal_detalle").modal("hide");

                    $.alert({
                        title: 'Confirmación',
                        content: "<i class='fa fa-check-circle' aria-hidden='true'></i> Requisición autorizada correctamente.",
                        confirmButtonClass: "btn-success",
                        confirm: function() {
                            window.location.replace(url_root + "?qs=requisiciones-pendientes");
                        },
                    });
                }else{
                    $("#btn_aut"+requisicion_id).removeAttr("disabled");
                    $("#btn_aut"+requisicion_id).html("Autorizar");

                    $.alert({
                        title: '',
                        content: "No se pudo completar la solicitud.",
                        confirmButtonClass: "btn-success",
                        confirm: function() {
                            window.location.replace(url_root + "?qs=home");
                            return false;
                        },
                    });
                }
            });
        },error: function(xhr,status,error){
            $("#btn_aut"+requisicion_id).removeAttr("disabled");
            $("#btn_aut"+requisicion_id).html("Autorizar");

            $.alert({
                title: '',
                content: "No se pudo completar la solicitud.",
                confirmButtonClass: "btn-success",
                confirm: function() {
                },
            });
        }
    });
}


function modal_imagen(imagen){
    var url = $("#modal_img").attr("url");

    if (imagen == 'SIN ARCHIVO'){
        imagen = "https://serviciosweb.vallen.com.mx/img/prod/no-image.jpg";
    }
    console.log("imagen: "+imagen)

    $("#img_cargada").attr("src",imagen);
    $("#modal_img").modal();
}
*/