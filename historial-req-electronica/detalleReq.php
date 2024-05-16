<?php
/*header("Access-Control-Allow-Origin: *");
header('Content-type: application/json');*/
/*ini_set('display_errors','on');
error_reporting(E_ALL);*/

function getResponse(){
      $rawdata = array();
      
      if ($_POST["requisicion_id"] > 0){
            
            if(!isset($_SESSION["USUARIO_ID"])){
                  $rawdata["EVENTO"] ="NOT_SESSION";
            }else{
                  $usuario_id             = $_SESSION["USUARIO_ID"];
                  $requisicion_id         = $_POST["requisicion_id"];
                  $envio_autorizacion     = $_POST["envio_autorizacion"];
                  $codigo_aut             = $_POST["codigo_aut"];
                  $cliente_id             = $_SESSION["CLIENTE_ID"];
                  $lista_cot = "";
                  $req_cliente = 0;

                  $objCotizador   = new cotizadorAbierto();
                  $dataCotizador = array("opcion"=>12,"cabecera_id"=>$requisicion_id,"folio_cotizacion_maps"=>"","cotizacion_id"=>0,"documento_id"=>0,"cliente_id"=>$_SESSION["CLIENTE_ID"],"nombre_cliente"=>$_SESSION["RAZON_SOCIAL"],"usuario_id"=>$usuario_id,"nombre_usuario"=>$_SESSION["NOMBRE_USUARIO"],"partida_id"=>0,"numero_parte"=>'',"descripcion"=>'',"tipo_articulo"=>'',"marca"=>'',"cantidad"=>'',"unidad_medida_id"=>0,"nombre_unidad_medida"=>'',"almacen_id"=>$_SESSION["ALMACEN_ID"]);
                  $resCotizador  = $objCotizador->sp_B2BCotizadorAbierto($dataCotizador);  

                  // debug($resCotizador, false);

                  $precio = 100;
                  if (count($resCotizador[0]) > 0){
                        foreach ($resCotizador[0] as $partida) {

                              if ((int)$partida[TIEMPO_ENTREGA] > 0){
                                    $t_entrega = (int)$partida[TIEMPO_ENTREGA];
                              }else{
                                    $t_entrega = "-";
                              }

                              if ($_SESSION["AUTORIZA_B2B"] == 1 && $envio_autorizacion == 1){
                                    $td_cantidad = '<input type="text" id="cant_inp_'.$partida[PARTIDA_ID].'" value="'.(int)$partida[CANTIDAD].'" style="width:100px;" cantidad1="'.(int)$partida[CANTIDAD].'">';
                              }else{
                                    $td_cantidad = (int)$partida[CANTIDAD];
                              }

                              $lista_cot.='<tr>
                                                <td class="text-center">'.$partida[CLAVE_PROVEEDOR].'</td>
                                                <td class="text-center">'.$partida[DESCRIPCION_ARTICULO].'</td>
                                                <td class="text-center">'.$partida[MARCA].'</td>
                                                <td class="text-center">'.$td_cantidad.'</td>
                                                <td class="text-center">$ '.$partida[PRECIO].'</td>
                                                <td class="text-center">$ '.$partida[TOTAL_PARTIDA].'</td>
                                                <td class="text-center">'.$partida[MONEDA_COMPRA].'</td>
                                                <td class="text-center">'.$partida[UNIDAD_ARTICULO].'</td>
                                                <td class="text-center">'.$t_entrega.'</td>
                                                <td class="text-center">'.$partida[CUENTA].'
                                                <!--
                                                <div class="input-group" style="width:200px;">
                                                      <span class="input-group-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                                                      <input type="text" class="form-control fz-14" id="cuenta_cargo'.$partida[PARTIDA_ID].'" value="'.$partida[CUENTA].'" onkeyup="javascript:busca_catalogo(2,'.$partida[PARTIDA_ID].','.$partida[PARTIDA_ID_B2B].');" style="font-size:12px!important;">
                                                      <input type="hidden" class="form-control fz-14" id="cuenta_cargo_id'.$partida[PARTIDA_ID].'" value="'.$partida[CUENTA_ID].'">
                                                </div>
                                                <ul class="busq-resultados" id="lista_cuentas'.$partida[PARTIDA_ID].'" style="top: 57px; display: none;left: 30px;width:30%;">
                          
                                                </ul>
                                                -->
                                                </td>
                                                <td class="text-center"><button type="button" class="btn btn-warning" id="btn_imagen3568" onclick="javascript:modal_imagen(\''.$partida[IMAGEN].'\');"><i class="fa fa-picture-o" aria-hidden="true"></i></button></td>
                                                <td class="text-center">
                                                      <input type="checkbox" value="'.$partida[PARTIDA_ID].'" cantidad="'.(INT)$partida[CANTIDAD].'" name="selecciona_cot" id="check_partida'.$partida[PARTIDA_ID].'">
                                                </td>
                                          </tr>';
                        }
                  }else{
                        $lista_cot.='<tr><td colspan="6" class="text-center">No se encontraron registros.</td></tr>';
                  }

                  if ($_SESSION["AUTORIZA_B2B"] == 1 && $envio_autorizacion == 1){
                       $botones_modal = '<input type="text" class="form-control pull-left" style="display:inline-block;width:200px;" placeholder="Código de Autorización" id="codigo_aut">
                                          <button class="btn btn-danger" type="button" id="btn_denegar'.$requisicion_id.'" onclick="javascript:deniega_req('.$requisicion_id.',2);">Denegar</button>
                                         <button class="btn btn-success" type="button" id="btn_aut'.$requisicion_id.'" onclick="javascript:autoriza_req('.$requisicion_id.','.$_SESSION["USUARIO_ID"].');">Autorizar</button>';

                        $comentarios = '  <label for="comentarios_despacho">Comentarios</label>
                                          <textarea class="form-control" id="comentarios_despacho" rows="3"></textarea>';
                  }else{
                        if ($_SESSION["REQ_INTERNA_CLIENTE"] == 1){
                              $req_cliente = 1;
                              $botones_modal = '<div class="col-md-3">
                                                      <input type="text" value="" class="form-control" placeholder="Req. Interna" id="btn_regint_'.$requisicion_id.'">
                                                </div>';
                        }

                        $botones_modal .= '<button class="btn btn-danger" type="button" id="btn_denegar'.$requisicion_id.'" onclick="javascript:deniega_req('.$requisicion_id.',2);">Denegar</button>
                                          <button class="btn btn-primary" type="button" onclick="javascript:preautoriza_cot('.$requisicion_id.','.$req_cliente.','.$cliente_id.');" id="btn_'.$requisicion_id.'">Enviar Autorización</button>';

                        $comentarios = '  <label for="comentarios_despacho">Comentarios</label>
                                          <textarea class="form-control" id="comentarios_despacho" rows="3"></textarea>';
                  }
                  
                  $rawdata["EVENTO"] ="OK";
                  $rawdata["LISTA_DETALLE"] = $lista_cot;
                  $rawdata["BOTONES_MODAL"] = $botones_modal;
                  $rawdata["AREA_COMENTARIOS"] = $comentarios;
            }
      }else{
            $rawdata["EVENTO"] ="ERROR";
      }

      return $rawdata;
}

$response = getResponse();
echo json_encode($response);
?>