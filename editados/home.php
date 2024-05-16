<?php
/*ini_set('display_errors','on');
error_reporting(E_ALL);*/

//Dentro de las variables se está cargando nuevas variables de tipo http (header, login, etc)
$header = new header();
$footer = new footer();
$menu = new menu();
$login = new login();
$sinExistenciasModal = new sin_existencia();
$fecha = gmdate("dmYHis");

/*if ($_SESSION["USUARIO_ID"] == 446952){
    debug($_SESSION);
}*/

/*******************Complementos de Header y Footer*******************/
$headComplement = ' <link rel="stylesheet" href="' . WS_APP_CSS . 'owl.carousel.css?v=' . $fecha . '" />
                    <link rel="canonical" href="https://serviciosweb.vallen.com.mx/">
                    <link rel="stylesheet" href="' . WS_APP_CSS . 'hover-box.css?v=' . $fecha . '" />
                    ';

$headMeta ='';

$footerComplement =' 
                    <script src="' . WS_APP_JS . 'owl.carousel.min.js?v=' . $fecha . '"></script>
                    <script type="text/javascript">
                        /*$("tbody tr").attr("onclick","javascript:load();");
                        $("tbody tr").attr("style","cursor:pointer;");

                        function load() {
                        top.location="?qs=detalle";
                        }*/
                    </script>
                    <script src="'.WS_VIEWS.'home/home.js?v='.$fecha.'"></script>
                    ';

$menuComplement ='';

$loginComplemetn = '';

if ($_SESSION["USUARIO_ECOMMERCE"] == "CATALOGO ABIERTO") {
    $opcion_cat=2;
    $url_cat = "mis-productos";
    $catalogo_b2b="mis-productos";
}else{
    if(isset($_GET[p1])){ //catálogos
        $catalogo_b2b=$_GET[p1];

        if($_GET[p1]=='mis-productos'){ //catálogos
            $opcion_cat=1;
            $url_cat="mis-productos";
        }else if($_GET[p1]=='catalogo-vallen'){
            $opcion_cat=2;
            $url_cat="vallen-mx";
        }else if ($_GET[p1]=='vallen-usa'){
            $opcion_cat=3;
            $url_cat="vallen-usa";
        }else{
            $opcion_cat=1;
            $url_cat="mis-productos";
        }
    }else{
        $catalogo_b2b="mis-productos";
        $url_cat="mis-productos";
        $opcion_cat=1;
    }
}
/********************************************************************/
/*if ($_SESSION["USUARIO_ID"] == 400193){
    debug($_SESSION,FALSE);
}*/
/******************Extraccion de informacion del SP******************/
$headMain = $header->getHeaderMain(1,$headComplement,22);
$footerMain = $footer->getFooterMain(1, $footerComplement);
$menuMain  = $menu->getMenuMain(1,$menuComplement); //se mete dentro de VAR:MENU, se usa clase de menu.class.php
$loginMain  = $login->getLoginMain(1,$loginComplement);
// $reporteRequisiciones  = $menu->getMenuMain(2,$menuComplement);
$sinExistenciaMain   = $sinExistenciasModal->getSinExistencia(1,$sinExistenciaComplement);
/********************************************************************/

/****************Extraer banner(s) de db*****************************/
$bannerObj = new obtenerBanner();
$dataBanner = array("opcion"=> 1,"tipo_banner_id" => 2, "enabled" => 1, "clasif_web" => 1, "seccion_id" => 15);
$dataObtenerBanner = $bannerObj->sp_ObtenerBanner($dataBanner);
$IMAGES_SLIDER = '<div class="slide_group">';
$LI_BANNER = "";
$contador = 0;                    
foreach ($dataObtenerBanner as $dataRowBanner) {
    if ($contador==0){
        $activeb="active";
    }else{
        $activeb="";
    }

    $LINK_B = strpos($dataRowBanner[LINK_BANNER], "http");
    if ($LINK_B == false) {
        $URL_BANNER=$dataRowBanner[LINK_BANNER];
    }else{
        $URL_BANNER=WS_ROOT.$dataRowBanner[LINK_BANNER];
    }

    if ($dataRowBanner[BLANK]==1){
        $target_url="_blank";
    }else{
        $target_url="";
    }

    $LI_BANNER .= '
        <li data-target="#carouselExampleIndicators" data-slide-to="'.$contador.'" class="'.$activeb.'"></li>
    ';
    $IMAGES_SLIDER .= ' 
                    <div class="carousel-item '.$activeb.'">
                        <a href="'.$URL_BANNER.'" target="'.$target_url.'">
                            <img class="d-block w-100" src="https://serviciosweb.vallen.com.mx/img/banners/'.$dataRowBanner[IMAGEN_BANNER].'" alt="'.$dataRowBanner[ALT_BANNER].'">
                        </a>
                    </div>';
    $contador=$contador+1;
}

$IMAGES_SLIDER .= '</div>';
/********************************************************************/

//Variables de imagenes y permisos que se sacan de clases

$imgPrincial = new buscaImagenArt();
$objPermiso = new permisos();


    $OCULTAR_TOP_TEN = "hide";

    $catalogomx  = $objPermiso->get_permiso("OCULTA_CATALOGO_MX",$opcion_cat); // se llama a la clase get permiso y se mete dentro de la variable objpermiso
    $catalogousa = $objPermiso->get_permiso("OCULTA_CATALOGO_USA",$opcion_cat);
if ($_SESSION["USUARIO"] == 'B2B04-1410CATA8'){
    $cat_mx_img = 'cat-misproductos.jpg';
    $cat_usa_img = 'cat-misproductos.jpg';
}else{
    $cat_mx_img = 'cat-mx.jpg';
    $cat_usa_img = 'cat-usa.jpg';
}

//Se despliega el catalago si se cumple la condicion 
if ($_SESSION["USUARIO_ECOMMERCE"] == "CATALOGO ABIERTO"){
    $menu_catalogos = ' <div class="col-md-4 text-center offset-md-2">
                            <a href="'.WS_ROOT.'catalogo-vallen">
                                <img src="'.WS_APP_IMG.'catalogo-general.jpg" class="img-fluid" style="height: 170px!important;">
                            </a>
                        </div>
                        <div class="col-md-4 text-center">
                            <a href="'.WS_ROOT.'exclusivos-vallen">
                                <img src="'.WS_APP_IMG.'promociones.jpg" class="img-fluid" style="height: 170px!important;">
                            </a>
                        </div>';
}else{

   if ($_SESSION['USUARIO_ID'] == 464199){
        $img_cat = 'mis-productos-sherwinw.jpg';
    }else{
        $img_cat = 'mis-productos.jpg';
    }

    $menu_catalogos = ' <div class="col-md-4 text-center">
                            <a href="'.WS_ROOT.'mis-productos">
                                <img src="'.WS_APP_IMG.$img_cat.'" class="img-fluid" style="height: 170px!important;">
                            </a>
                        </div>';


    if ($_SESSION["OCULTA_CATALOGO_MX"] <> 1){
        $menu_catalogos .= '<div class="col-md-4 text-center">
                                <a href="'.WS_ROOT.'catalogo-vallen">
                                    <img src="'.WS_APP_IMG.'catalogo-general.jpg" class="img-fluid" style="height: 170px!important;">
                                </a>
                            </div>';
        if ($_SESSION["USUARIO_ID"] == 445849){ //PEPSICO - TALLERES
            $menu_catalogos .=  '<div class="col-md-4 text-center">
                                    <a href="'.WS_ROOT.'talleres">
                                        <img src="'.WS_APP_IMG.'b2b-talleres.jpg" class="img-fluid" style="height: 170px!important;">
                                    </a>
                                </div>';
        }else{
            $menu_catalogos .=  '<div class="col-md-4 text-center">
                                    <a href="'.WS_ROOT.'exclusivos-vallen">
                                        <img src="'.WS_APP_IMG.'promociones.jpg" class="img-fluid" style="height: 170px!important;">
                                    </a>
                                </div>';
        }
    }
}

/*****************Carga en vista*************************************/
$oTpl->loadInicio(FS_HOME . 'home.html');
$oTpl->setVar(
    array(
        'HEADER' =>  $headMain,
        'FOOTER' =>  $footerMain,
        'SINEXISTENCIAS_MODAL' => $sinExistenciaMain,
        'USERNAME'=> $username,
        'URL_IMAGES' => WS_APP_IMG,
        'URL_CONFIG' => WS_CONFIG,
        'IMAGES_SLIDER' => $IMAGES_SLIDER,
        'LI_BANNER' => $LI_BANNER,
        'TOP_ARTICULOS' => $TOP_ARTICULOS,
        'MENU' => $menuMain, //Se muestra en home.html, saca de la variable menuMain en este mismo archivo.
        'MODAL_LOGIN' => $loginMain,
        // 'TOP3CAT' => $familia_cat,
        //'MARCAS_DESTACADAS' => $listaMarcas,
        'URL_ROOT' => WS_ROOT,
        // 'REPORTE_REQUISICIONES' => $reporteRequisiciones,
        'OCULTAR_TOP_TEN' => $OCULTAR_TOP_TEN,
        'URL_CATMX' => $catalogomx,
        'URL_CATUSA' => $catalogousa,
        'CAT_MX_IMG' => $cat_mx_img,
        'CAT_USA_IMG' => $cat_usa_img,
        'MENU_CATALOGOS' => $menu_catalogos,
        'FECHA_VIDEO' => $fecha,
    )
);
    $oTpl->publish();
?>