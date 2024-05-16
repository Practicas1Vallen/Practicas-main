<?php
/*header("Access-Control-Allow-Origin: *");
header('Content-type: application/json');*/
/*ini_set('display_errors','on');
error_reporting(E_ALL);*/

function getResponse(){
      $rawdata = array();
      
      if ($_POST["partida_id"] > 0){
            
            if(!isset($_SESSION["USUARIO_ID"])){
                  $rawdata["EVENTO"] ="NOT_SESSION";
            }else{
              $usuario_id  = $_SESSION["USUARIO_ID"];
              $partida_id  = $_POST["partida_id"];
              $cuenta_id   = $_POST["cuenta_id"];

              $objRequisicionE   = new requisicionElectronica();
              $dataRequisicionE = array("opcion"=>11,"cuenta_cargo_id"=>$cuenta_id,"partida_id"=>$partida_id);
              $resRequisicionE  = $objRequisicionE->sp_B2BRequisicionElectronica($dataRequisicionE);  
             
              $rawdata["EVENTO"] ="OK";
            }
      }else{
            $rawdata["EVENTO"] ="ERROR";
      }

      return $rawdata;
}

$response = getResponse();
echo json_encode($response);
?>