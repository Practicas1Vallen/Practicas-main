function detalle_solicitud(id_documento,folio,estatus){
	var url = $("#table-solicitudes").attr("url_detalle");
    $("#codigo_aut").val("");

	$.ajax({
        dataType: "json",
        type: "POST",
        timeout: 50000,
        data: { id_documento: id_documento,estatus:estatus },
        url: url,
        success: function(data) {
            if (data.EVENTO == 'OK') {
            	$("#folio_sol").html("Folio: "+folio);
                $("#aut_pendiente").html("Autorizador Pendiente: "+data.AUTORIZACIONES);
                $("#niveles").html("Niveles de aprobación: "+data.NIVELES);
                $("#contenido_detalle").html(data.TABLA);
                $("#modal_btns").html(data.BTNS_MODAL);
				$("#modal_detalle").modal('show');
            } else if (data.EVENTO == 'NOT_SESSION') {
            	top.location="?qs=login";
            } else {
                $.alert({
                    title: 'Error',
                    content: "<i class='fa fa-times-circle' aria-hidden='true'></i> No se pudo completar tu solicitud, por favor inténtalo más tarde.",
                    confirmButtonClass: "btn-success"
                });
            }
        },
        error: function(xhr, status, error) {
            $.alert({
                title: 'Error',
                content: "<i class='fa fa-times-circle' aria-hidden='true'></i> Se perdio la conexión con el servidor, por favor inténtalo más tarde.",
                confirmButtonClass: "btn-success"
            });
        }
    })
}

function deniega_pullticket(documento_id,tipo) {
    var url = $("#modal_detalle").attr("url_deniega_pt");
    var url_root = $("#menu_top").attr("url_root");
    var usuario_id = $("#usuario_id").val();
    var solicitante_id = $("#solicitante_id").val();
    var comentarios_despacho = $("#comentarios_despacho").val();

    $.confirm({
        content: "Confirma que deseas cancelar la solicitud.",
        title: "Confirmación",
        confirm: function(button) {        
            $("#cancel_sol").attr("disabled", true);
            $("#cancel_sol").html("PROCESANDO...");

            $.ajax({
                url: "https://maps-norte.vallen.com.mx/maps/pullticket/deniegapullticket.php",
                data: { DOCUMENTO_ID: documento_id, USUARIO_ID: usuario_id,SOLICITANTE_ID:solicitante_id,CAUSA:comentarios_despacho},
                type: 'get',
                dataType: 'jsonp',
                callbackParameter: 'callback',
                success: function(data_json) {
                    $.each(data_json, function(i, item) {
                        var RESULTADO = item.RESULTADO || 0;
                        if (RESULTADO == 1) {
                            $("#modal_detalle").modal("hide");
                            $("#cancel_sol").removeAttr("disabled");
                            $("#cancel_sol").html("CANCELAR");

                            $("#id_sol"+documento_id).remove();

                            $.alert({
                                title: 'Confirmación',
                                content: "<div class='text-center'><i class='fa fa-check-circle' aria-hidden='true'></i> Solicitud cancelada correctamente.</div>",
                                confirmButtonClass:"btn-success",
                                confirm: function(){
                                    if (tipo==1){
                                        window.location.replace(url_root + "?qs=solicitudes");
                                    }else{
                                        $("#detalle_pt"+documento_id).remove();
                                    }
                                },
                            });
                        }
                    });
                }
            });

        },
        cancel: function(button) {},
        confirmButton: "Aceptar",
        cancelButton: "Cancelar",
        confirmButtonClass: "btn-success",
        cancelButtonClass: "btn-default",
        dialogClass: "modal-dialog modal-lg"
    })
}

function autoriza_sol(documento_id,usuario_id){
    var url_root = $("#menu_top").attr("url_root");
    var codigo_autorizacion = $("#codigo_aut").val()||"";

    if (codigo_autorizacion == ""){
        $.alert({
            title: 'Alerta',
            content: "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Ingresa el código de autorización.",
            confirmButtonClass:"btn-success"
        });
        return false;
    }

    $("#aut_sol").attr("disabled",true);
    $("#aut_sol").html("Procesando <i class='fa fa-refresh fa-spin'></i>");

    $.ajax({
        url: "https://maps-norte.vallen.com.mx/maps/pullticket/autorizapullticketxnivelcod.php",
        data: { DOCUMENTO_ID:documento_id,USUARIO_ID:usuario_id,CODIGO_AUT:codigo_autorizacion },
        type: 'get',
        dataType: 'jsonp',
        callbackParameter: 'callback',
        success: function(data_json) {
            $.each(data_json, function(i, item) {
                var RESULTADO = item.RESULTADO || 0;
                if (RESULTADO == 1) {
                    $("#codigo_aut").val("");
                    $("#aut_sol").removeAttr("disabled");
                    $("#aut_sol").html("Autorizar");
                    $("#modal_detalle").modal("hide");

                    $.alert({
                        title: 'Confirmación',
                        content: "<i class='fa fa-check-circle' aria-hidden='true'></i> "+item.MENSAJE,
                        confirmButtonClass: "btn-success",
                        confirm: function() {
                            window.location.replace(url_root + "?qs=solicitudes");
                        },
                    });
                }else{
                    $("#aut_sol").removeAttr("disabled");
                    $("#aut_sol").html("Autorizar");

                    $.alert({
                        title: 'Alerta',
                        content: "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> "+item.MENSAJE,
                        confirmButtonClass:"btn-success"
                    });
                    return false;
                }
            });
        },error: function(xhr,status,error){
            $("#aut_sol").removeAttr("disabled");
            $("#aut_sol").html("Autorizar");

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