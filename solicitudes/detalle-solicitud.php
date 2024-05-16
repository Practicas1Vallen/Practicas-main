<?php
/*header("Access-Control-Allow-Origin: *");
header('Content-type: application/json');*/
//ini_set('display_errors','on');
//error_reporting(E_ALL);
function getResponse(){
	$rawdata = array();
	
	if ($_POST["id_documento"] > 0){
		if(!isset($_SESSION["USUARIO_ID"])){
        	$rawdata["EVENTO"] ="NOT_SESSION";
		}else{
			$id_documento = $_POST["id_documento"];
			// $estatus = $_POST["estatus"];

			$solicitudesPtObj = new pullticketSolicitudes();
			$dataSolPt = array('opcion' => 4,'cliente_id' => $_SESSION["CLIENTE_ID"] ,'usuario_id'=> $_SESSION["USUARIO_ID"],'documento_id' => $id_documento);
			$dataObtenerSol = $solicitudesPtObj->sp_B2BPullticketSolicitudes($dataSolPt);
			$estado_id = $dataObtenerSol[0][0][ESTADO_DOCUMENTO];
			$autorizaciones = $dataObtenerSol[0][0][AUTORIZADOR_PENDIENTE];
			$niveles = $dataObtenerSol[0][0][NIVELES_AUT];

			// die($estado_id . " ESTADO_ID");
			

			$tabla="";
			if (count($dataObtenerSol[1]) > 0){
				foreach ($dataObtenerSol[1] as $detalle) {
					$tabla.="<tr>
	                            <td>".$detalle[CLAVE]."</td>
	                            <td>".$detalle[NOMBRE_ARTICULO]."</td>
	                            <td>".$detalle[CANTIDAD]."</td>
	                            <td>".$detalle[TOTAL]."</td>
	                        </tr>";
				}
			}else{
					$tabla.="<tr><td colspan='4'>No se encontraron resultados.</td></tr>";
			}


			if ($estado_id == 0){
				$btns_modal ='
					<input type="text" class="form-control pull-left" style="display:inline-block;width:200px;" placeholder="Código de Autorización" id="codigo_aut">
					<button type="button" class="btn btn-danger text-truncate" data-dismiss="modal" id="cancel_sol" onclick="javascript:deniega_pullticket('.$id_documento.',1)">Cancelar Solicitud</button>
					<button type="button" class="btn btn-success text-truncate" id="aut_sol" onclick="javascript:autoriza_sol('.$id_documento.','.$_SESSION["USUARIO_ID"].')">Autorizar</button>
                    <button type="button" class="btn btn-default text-truncate" data-dismiss="modal">Cerrar</button>
					';
			}else{
				$btns_modal ='
					<button type="button" class="btn btn-danger text-truncate" data-dismiss="modal" id="cancel_sol" onclick="javascript:deniega_pullticket('.$id_documento.',1)">Cancelar Solicitud</button>
                    <button type="button" class="btn btn-default text-truncate" data-dismiss="modal">Cerrar</button>
					';
			}

        	$rawdata["EVENTO"] = "OK";
        	$rawdata["TABLA"] = $tabla;
        	$rawdata["BTNS_MODAL"] = $btns_modal;
        	$rawdata["AUTORIZACIONES"] = $autorizaciones;
        	$rawdata["NIVELES"] = $niveles;
		}
	}else{
        $rawdata["EVENTO"] ="ERROR";
	}

	return $rawdata;
}

$response = getResponse();
echo json_encode($response);
?>