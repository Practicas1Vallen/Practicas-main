<?php
/*ini_set('display_errors','on');
error_reporting(E_ALL);*/

//20240209.FEN-debug($_SESSION,false);
//Variables
$header = new header();
$footer = new footer();
$menu = new menu();
$login = new login();
$fecha = gmdate("dmYHis");

/*******************Complementos de Header y Footer*******************/
$headComplement = ' <link rel="stylesheet" href="' . WS_APP_CSS . 'owl.carousel.css?v=' . $fecha . '" />
                    <link rel="canonical" href="https://serviciosweb.vallen.com.mx/">
                    <link rel="stylesheet" href="' . WS_APP_CSS . 'hover-box.css?v=' . $fecha . '" />
                    <link rel="stylesheet" href="' . WS_APP_CSS . 'css-complement.css?v=' . $fecha . '" />
                    ';

$headMeta ='';
$footerComplement ='<script src="' . WS_VIEWS . 'tokens/solicitudes.js?v=' . $fecha . '"></script>';
$menuComplement ='';
$loginComplemetn = '';


/******************Extraccion de informacion del SP******************/
$headMain = $header->getHeaderMain(1,$headComplement,''); //primer argumento (1) puede indicar tipo de encabezado que se elige, el ultimo algun argumento opcional
$footerMain = $footer->getFooterMain(1, $footerComplement);
$menuMain  = $menu->getMenuMain(1,$menuComplement);
$loginMain  = $login->getLoginMain(1,$loginComplement);
$breadCrumb = getBreadCrumb();
$reporteRequisiciones  = $menu->getMenuMain(2,$menuComplement);
/********************************************************************/

$solicitudesPtObj = new pullticketTokens();
$dataSolPt = array('opcion' => 0,'cliente_id' => $_SESSION["CLIENTE_ID"] ,'usuario_id'=> $_SESSION["USUARIO_ID"],'solicitante_id'=>7224034);
$dataObtenerSol = $solicitudesPtObj->sp_B2BPullticketTokens($dataSolPt);//sp_B2BPullticketTokens Esta es una función y debe estar definida en una clase en MODELS 



//$dataCant - Arreglo para solicitar la cantidad de articulos
//$resCant - Regresa la cantidad de articulos
//$dataAut - Arreglo para solicitar las solicitudes pendientes 
//restAut - Cantidad de solicitudes pendientes

$lista = "";
if (count($dataObtenerSol[0] > 0)){
    foreach ($dataObtenerSol[0] as $solicitud) {
        $fecha_sol= str_replace("/","-",$solicitud[FECHA]); 

        $lista.=
        '<td>'.$solicitud[FOLIO].'</td> 
        <td>'.date("d-m-Y H:i", strtotime($fecha_sol)).'</td>   
        <td>'.$solicitud[TOKEN_PULLTICKET].'</td>
        </tr>';                
}
}else{
$lista.='<tr><td colspan="5">No se encontraron resultados.</td></tr>'; 
}

if ($lista == ""){
$lista='<tr><td colspan="5">No se encontraron resultados.</td></tr>'; 
}

if ($autorizador_sol == ""){
$letrero_autorizador="";
}else{
$letrero_autorizador="<p> Autorizador: ".$autorizador_sol."</p>";
}



/*****************Carga en vista*************************************/
$oTpl->loadInicio(FS_TOKENS.'/tokens.html');
$oTpl->setVar(
    array(
        'HEADER' =>  $headMain, //Dentro de header entra lo que esta en headMain
        'FOOTER' =>  $footerMain,
        'USERNAME'=> $username,
        'REPORTE_REQUISICIONES' => $reporteRequisiciones,
        'URL_IMAGES' => WS_APP_IMG,
        'MENU' => $menuMain,
        'URL_ROOT' => WS_ROOT,
        'BREADCRUMB' => $breadCrumb,
        'SOLICITUDES' => $lista,
        'AUTORIZADOR' => $letrero_autorizador,
        'USUARIO_ID' => $_SESSION["USUARIO_ID"],
        'SOLICITANTE_ID' => $_SESSION["SOLICITANTE_ID"],
        'URL_DETALLE'  => encodeQueryString(array('do' => FS_VIEWS . 'tokens/detalle-solicitud')),
        'URL_DENIEGA_PULLTICKET' => encodeQueryString(array('do' => FS_CARRITO . 'deniegaPullticket')),
    )
);
	$oTpl->publish();
?>