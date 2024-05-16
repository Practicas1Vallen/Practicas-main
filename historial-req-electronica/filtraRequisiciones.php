<?php
/*header("Access-Control-Allow-Origin: *");
header('Content-type: application/json');*/
/*ini_set('display_errors','on');
error_reporting(E_ALL);*/

function getResponse(){
      $rawdata = array();
      
      if ($_POST["fecha_inicial"] != "" && $_POST["fecha_final"] != ""){
            
            if(!isset($_SESSION["USUARIO_ID"])){
                  $rawdata["EVENTO"] ="NOT_SESSION";
            }else{
                  $usuario_id       = $_SESSION["USUARIO_ID"];
                  $fecha_ini        = str_replace("/","-",$_POST["fecha_inicial"]); 
                  $fecha_fin        = str_replace("/","-",$_POST["fecha_final"]); 
                  $fecha_inicial    = date("Y-m-d", strtotime($fecha_ini));
                  $fecha_final      = date("Y-m-d", strtotime($fecha_fin));
                  $tabla            = "";

                  $objCotizador   = new cotizadorAbierto();
                  $dataCotizador = array("opcion"=>14,"cabecera_id"=>0,"folio_cotizacion_maps"=>"","cotizacion_id"=>0,"documento_id"=>0,"cliente_id"=>$_SESSION["CLIENTE_ID"],"nombre_cliente"=>$_SESSION["RAZON_SOCIAL"],"usuario_id"=>$usuario_id,"nombre_usuario"=>$_SESSION["NOMBRE_USUARIO"],"partida_id"=>0,"numero_parte"=>'',"descripcion"=>'',"tipo_articulo"=>0,"marca"=>'',"cantidad"=>0,"unidad_medida_id"=>0,"nombre_unidad_medida"=>'','almacen_id' =>0,'razon_social' => '','correo_cot' => '','nombre_cot' =>'','cot_id' => 0,'fecha_inicial' =>$fecha_inicial,'fecha_final' => $fecha_final);
                  $resCotizador  = $objCotizador->sp_B2BCotizadorAbierto($dataCotizador);  

                  //debug($resCotizador,false);

                  if (count($resCotizador[0]) > 0 ){
                        $resultado = 1;
                        /*foreach ($resCotizador[0] as $cotizacion) {
                              $fechahora=explode(" ", $cotizacion['FECHA']);     
                              $fecha=$fechahora[0];   
                              $fecha=explode("/", $fecha);
                              $ano_p=$fecha[2];
                              $mes_p=$fecha[1];
                              $dia_p=$fecha[0];
                              $fecha_alta=$dia_p."/".$mes_p."/".$ano_p;

                              if (isset($cotizacion[VIGENCIA])){
                                    $vigencia = date("d/m/Y", strtotime($cotizacion[VIGENCIA]));
                              }else{
                                    $vigencia = "-";
                              }

                              $autorizar = '<label class="badge badge-info">'.$cotizacion[ESTATUS].'</label>';

                              $tabla .= '<tr>
                                                <td>'.$cotizacion[FOLIO].'</td>
                                                <td style="width: 250px;" class="text-center">'.$fecha_alta.'</td>
                                                <td style="width: 400px;" class="text-center">'.$vigencia.'</td>
                                                <td style="width: 250px;">'.$cotizacion[SOLICITANTE].'</td>
                                                <td style="width: 250px;">'.$cotizacion[MONEDA].'</td>}
                                                <td style="width: 250px;">'.$cotizacion[OBSERVACION].'</td>
                                                <td style="width: 250px;">'.$cotizacion[TOTAL].'</td>
                                                <td style="width: 250px;">'.$autorizar.'</td>
                                                <td style="width: 100px;" id="td_'.$cotizacion[REQUISICION_ID].'">
                                                    <button class="btn btn-warning" id="btn_detalle'.$cotizacion[REQUISICION_ID].'" onclick="javascript:detalle_cotizacion_pendiente('.$cotizacion[REQUISICION_ID].','.$cotizacion[ENVIO_AUTORIZACION].');">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>';
                        }*/
                  }else{
                        $resultado = 0;
                  }

                  $rawdata["EVENTO"] ="OK";
                  $rawdata["CABECERA_ID"] = $resCotizador[0][0][CABECERA_CARRITO];
                  $rawdata["TABLA"] = $resCotizador[0];
                  $rawdata["RESULTADO"] = $resultado;
                  $rawdata["USUARIO_ID"] = $_SESSION["USUARIO_ID"];
            }
      }else{
            $rawdata["EVENTO"] ="ERROR";
      }

      return $rawdata;
}

$response = getResponse();
echo json_encode($response);
?>