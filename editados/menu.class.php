<?php

//EDITADO EN LINEA 653

class menu {

    public function getMenuMain($kindMenu,$complement){
        $dropDownCategorias = $this->dropDownCategorias();
        $compositeMenu = $this->kindMenu($kindMenu,$complement,'',$dropDownCategorias);
        return $compositeMenu; 
    }

    private function dropDownCategorias(){

        if ($_SESSION["USUARIO_ECOMMERCE"] == "CATALOGO ABIERTO") {
            $tipo_cat=2;
            $url_cat="catalogo-vallen";
        }else if ($_SESSION["USUARIO_ECOMMERCE"] == 7){
            $tipo_cat=7;
            $url_cat="mis-productos";
        }else{
            if($_GET[p1]=='catalogo-vallen'){
                $tipo_cat=2;
                $url_cat="catalogo-vallen";
            }else if($_GET[p1]=='catalogo-usa'){
                $tipo_cat=3;
                $url_cat="catalogo-usa";
            }else{
                $tipo_cat=1;
                $url_cat="mis-productos";
            }
        }

        if ($_SESSION["B2C_SFCC"] == 1 && $tipo_cat == 2){
            $tipo_cat = 6;
            $url_cat="catalogo-vallen";
        }

        $objCategorias = new familia();
        $dataCategorias = array('opcion' => $tipo_cat, 'usuario_id' => $_SESSION["USUARIO_ID"], 'cliente_id' => $_SESSION["CLIENTE_ID"], 'formulario_pullticket' => $_SESSION["FORMULARIO_PULLTICKET"], 'ocultar_servicio'=>$_SESSION["FORMULARIO"], 'cadena_cliente_id' =>(int)$_SESSION["CADENA_CLIENTE_ID"], 'super_familia' => 0);
        //debug($dataCategorias,false);
        $Categorias = $objCategorias->sp_B2BFamilia($dataCategorias);


        //If que cuenta las categorias y las despliega si son mas de 0 
        if (count($Categorias) > 0){
            $dropCategorias.='<li class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                <li class="dropdown-submenu">
                                    <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.$url_cat.'/seguridad/">
                                        Seguridad
                                    </a>
            ';
            $dropCategorias .= '<ul class="dropdown-menu">'; 

            
            foreach($Categorias as $rowCategorias){
                $dropCategorias .= '    <li class="dropdown">
                                            <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.$url_cat.'/seguridad/'.(INT)$rowCategorias[FAMILIA_ID].'" >
                                                '.ucwords(mb_strtolower($rowCategorias[DESCRIPCION])).'
                                            </a>
                                        </li>';
            }
            $dropCategorias.='      </ul>
                                </li>';
        }


        $objCategoriaMRO = new familia();
        $dataCategoriaMRO = array('opcion' => $tipo_cat, 'usuario_id' => $_SESSION["USUARIO_ID"], 'cliente_id' => $_SESSION["CLIENTE_ID"], 'formulario_pullticket' => $_SESSION["FORMULARIO_PULLTICKET"], 'ocultar_servicio'=>$_SESSION["FORMULARIO"], 'cadena_cliente_id' =>(int)$_SESSION["CADENA_CLIENTE_ID"], 'super_familia' => 1);
        $CategoriaMRO = $objCategoriaMRO->sp_B2BFamilia($dataCategoriaMRO); 

        /*debug($dataCategoriaMRO,false);
        debug($CategoriaMRO,false);*/

        
        //If que cuenta las categorias MRO y las despliega si son mas de 0 
        if (count($CategoriaMRO) > 0){
            $dropCategorias .= '
            <li class="dropdown-submenu">
                <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.$url_cat.'/mro/">
                    MRO
                </a>
            

                <ul class="dropdown-menu">';


            /*debug($CategoriaMRO,false);*/

            foreach($CategoriaMRO as $rowCategoriaMRO){

                $dropCategorias .= '    <li class="dropdown">
                                            <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.$url_cat.'/mro/'.(INT)$rowCategoriaMRO[FAMILIA_ID].'">
                                                '.ucwords(mb_strtolower($rowCategoriaMRO[DESCRIPCION])).'
                                            </a>
                                        </li>';        
            }
            $dropCategorias.='      </ul>
                                </li>
                            </li>';
        }
        
        return $dropCategorias;
    }

    private function kindMenu($kind,$complement,$dropDownMarcasPropias,$dropDownCategorias){
         if ($_SESSION["USUARIO_ECOMMERCE"] == "CATALOGO ABIERTO") {
            $tipo_cat=2; //tipo_cat =el tipo de catalogo que se va a mostrar (catalogo vallen, mis productos, etc)
            $url_cat="catalogo-vallen";
        }else if ($_SESSION["USUARIO_ECOMMERCE"] == 7){
            $tipo_cat=7;
            $url_cat="mis-productos";
        }else{
            if($_GET[p1]=='catalogo-vallen'){
                $tipo_cat=2;
                $url_cat="catalogo-vallen";
            }else if($_GET[p1]=='catalogo-usa'){
                $tipo_cat=3;
                $url_cat="catalogo-usa";
            }else{
                $tipo_cat=1;
                $url_cat="mis-productos";
            }
        }

        if ($_SESSION["B2C_SFCC"] == 1 && $tipo_cat == 2){
            $tipo_cat = 6;
            $url_cat="catalogo-vallen";
        }

        /*

        TIPOS DE CATALOGOS

        tipo_cat= 2 <-Catalogo-vallen
        tipo_cat= 3 <- catalogo-usa
        tipo_cat= 1 <-mis-productos
        */


        //************************ Solicitar permisos, se toman parametros de lo que se desea solicitar y el tipo de catalogo. ***********************
        $objPermiso = new permisos();
        $OCULTAR_SUCURSALES     = $objPermiso->get_permiso("OCULTAR_SUCURSALES",$tipo_cat); //recibe los permisos para realizar lo que se pide, en este caso Ocultar sucursales.
        $MOSTRAR_LOGO           = $objPermiso->get_permiso("MOSTRAR_LOGO",$tipo_cat); 
        $CONTACTA_ESPECIALISTA  = $objPermiso->get_permiso("CONTACTA_ESPECIALISTA",$tipo_cat);
        $REPORTEXSTATUS         = $objPermiso->get_permiso("REPORTEXSTATUS",$tipo_cat);
        $REPORTE_REQUISICIONES  = $objPermiso->get_permiso("REPORTE_REQUISICIONES",$tipo_cat);
        $ORDEN_ABIERTA          = $objPermiso->get_permiso("ORDEN_ABIERTA",$tipo_cat);
        $SOLICITUDES            = $objPermiso->get_permiso("SOLICITUDES",$tipo_cat);
        $AUTORIZAR_PULLTICKET   = $objPermiso->get_permiso("AUTORIZAR_PULLTICKET",$tipo_cat);
        $OCULTA_COTIZADOR_EXPRESS = "hide";//= $objPermiso->get_permiso("OCULTA_COTIZADOR_EXPRESS",$tipo_cat);

        if (isset($_SESSION["FORMULARIO_PULLTICKET"]) && $_SESSION["FORMULARIO_PULLTICKET"] == 1){
            $historial_visible = 0;
            $letrero_reporte = "Reporte Pull-tickets";
        }else{
            $historial_visible = 1;
            $letrero_reporte = "Reporte requisiciones";
        }

        if ($_SESSION["USUARIO_ID"] == 423557 || $_SESSION["USUARIO_ID"] == 439987){
            $redirect_home = WS_ROOT."home-catalogs";
        }else{
            $redirect_home = WS_ROOT;
        }

        if ((int)$_SESSION["USUARIO_ECOMMERCE"] == 7){ //CONSUMIBLES
            $url_cart = WS_ROOT.'carrito-consumibles';
        }else{
            $url_cart = WS_ROOT.'carrito';
        }

        if (isset($_SESSION['NOMBRE_USUARIO'])){
            $loginKind = '
                    <div class="login-box text-center header-cart-mini">
                        <div class="content-login navbar-nav btn-group cart-icon">    
                            <a href="#"  class="mt-30" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                                <i class="fa fa-user fasize" aria-hidden="true" style="color:#fff;"></i> 
                                '.ucwords(mb_strtolower(substr($_SESSION["NOMBRE_USUARIO"],0,15))).' <i class="fa fa-angle-down cart-icon" aria-hidden="true"></i>
                            </a>
                            <div class="dropdown-menu">';

                $loginKind.= $MOSTRAR_LOGO;
                            /*if ($_SESSION["LOGO_CLIENTE"]!="0"){
                $loginKind.='  <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4 offset-md-1 text-center d-lineblock">
                                            <img src="'.WS_ROOT.'app/config/images/cliente_logo/'.$_SESSION["LOGO_CLIENTE"].'" width="60" class="img-logo">
                                        </div>
                                        <div class="col-md-6 d-lineblock">
                                            <label class="loginmsg text-center img-logo" id="contrato-logo">
                                                Contrato: '.$_SESSION["CONTRATO_CLIENTE"].'
                                            </label>
                                        </div> 
                                    </div>
                                </div>';
                            }*/
            $loginKind.='       <a class="dropdown-item name-login bg-b" href="#">Bienvenido, '.ucwords(mb_strtolower(substr($_SESSION["NOMBRE_USUARIO"],0,20))).'</a>';

                            if ($_SESSION["CONTROL_PRESUPUESTO_WEBSHOP"] == 1){
            $loginKind.='       <a class="dropdown-item mt-2" href="'.WS_ROOT.'control-presupuestal-ws">Control Presupuesto</a>';
                            }

                            if ($_SESSION["CONSUMOS_BILLING"] == 1){
            $loginKind.='       <a class="dropdown-item mt-2" href="'.WS_ROOT.'consumos">Consumos</a>';
                            }

            $loginKind.='       <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:logout();">Cerrar Sesión</a>
                            </div>
                        </div>
                        <div class="content-login navbar-nav mt-30 top-cart-container header-cart-mini ml-3" id="TopCart" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" url="'.encodeQueryString(array('do' => FS_CARRITO . 'dropdownCart')).'">
                            <a href="" class="ml-2"><i class="fa fa-shopping-cart fasize" style="vertical-align:middle;color:#fff;" aria-hidden="true"></i>&nbsp;Carrito <i class="fa fa-angle-down cart-icon" aria-hidden="true"></i></a>
                        </div>
                        <div class="top-cart-content" aria-labelledby="TopCart">
                            <div class="top-cart-articulos">
                                <div class="row" id="info_cart">
                                    
                                </div>
                            </div>
                            <a href="'.$url_cart.'" class="btn btn-primary pull-right" role="button">
                                <span class="f-white">VER CARRITO</span>
                            </a>
                        </div>
                    </div>';
        }else{
           //logout
        }
           // debug($_SESSION,false);
        switch ($kind) {
            case 1:
                $res_kindMenu = '
                    <!-- Google Tag Manager (noscript) -->
                    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W3LKPM6"
                    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
            
                
                    <header class="container-fluid">
                        <div class="container-fluid top-bar">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="phone">
                                            <span><a href="tel:018008307930">Call Center: 01 800 830 7930</a></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <div class="menu">
                                            <span>
                                                <!--<i class="fa fa-users" aria-hidden="true"></i> Gracias por tus '.$_SESSION["VISITAS"].' visitas.
                                                <a href="#" id="chatsu"><i class="fa fa-comments fa-icon" aria-hidden="true"></i>Soporte</a>
                                                <a href="facturacion"><img class="icono" src="'.WS_APP_IMG.'icono-facturacion.jpg"/>Facturación</a>
                                                <a href="blog"><img class="icono" src="'.WS_APP_IMG.'icono-blog.jpg"/>Blog</a>-->
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid brand-content" id="menu_top" url_root="'.WS_ROOT.'" style="background-color:#09233C;">
                            <div class="row">
                                <!--------------------------menu------------------------------------->';

                            if ($_SESSION["MOSTRAR_LOGO"] == 1 && $_SESSION["LOGO_CLIENTE"]!="0"){
                            $res_kindMenu .= '
                                <div class="col-md-3">
                                    <div id="forgot" url="'.encodeQueryString(array('do' => FS_LOGOUT . 'logout')).'" class="logo">
                                        <a href="'.$redirect_home.'">
                                            <img class="img-fluid" src="'.WS_APP_IMG.'logo-vallen-B2C.png"/>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="search-box">
                                        <span>
                                            <div class="busqueda-cont mt-3">    
                                                <input type="search" id="search_input" onsearch="javascript:redirect_buscador(\''.$url_cat.'\');" url="'.encodeQueryString(array('do' => FS_MOTOR_BUSQUEDA . 'motor_busqueda')).'" url_cat="'.$url_cat.'" tipo="1" autocomplete="off"/>
                                                <!--<input type="search" id="search_input" onsearch="javascript:buscadorArticulos(2,\''.$url_cat.'\');" onkeyup="javascript:buscadorArticulos(1,\''.$url_cat.'\');" url="'.encodeQueryString(array('do' => FS_MOTOR_BUSQUEDA . 'motor_busqueda')).'"/>-->
                                                <button id="btn_search" type="button" class="btn-search text-center" onclick="javascript:redirect_buscador(\''.$url_cat.'\');">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                            <ul class="busq-resultados" id="busq-resultados" style="display: none;">
                                                
                                            </ul>
                                        </span>
                                    </div>
                                    <div class="main-menu hidden-sm-down">
                                        <ul class="nav justify-content-center">
                                            <li class="nav-item dropdown btn-group">
                                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#" style="padding:0!important;padding-top:8px!important;">
                                                   Productos
                                                </a>
                                                <ul class="dropdown-menu">
                                                    '.$dropDownCategorias.'
                                                </ul>
                                            </li>
                                            '.$CONTACTA_ESPECIALISTA.'';

                                        if ($_SESSION["COTIZADOR_ABIERTO"] == 1 && $_SESSION["USUARIO_ECOMMERCE"] != 'B2B PULLTICKET'){
                        $res_kindMenu .= '  <li class="nav-item dropdown btn-group">
                                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#" style="padding:0!important;padding-right:10px!important;">
                                                   Cotizador Abierto
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'cotizador-abierto/">
                                                            Generar cotización
                                                        </a>
                                                    </li>
                                                    <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'mis-cotizaciones/">
                                                            Mis Cotizaciones
                                                        </a>
                                                    </li>
                                                    <!--<li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'cotizaciones-pendientes/">
                                                            Cotizaciones Pendientes
                                                        </a>
                                                    </li>-->
                                                </ul>
                                            </li>';

                                        }else if ($_SESSION["REQUISICION_ELECTRONICA"] == 1){
                                            /*if ($_SESSION["AUTORIZA_B2B"] == 1){
                                                $letrero_req = ""
                                            }*/
                        $res_kindMenu .= '  <li class="nav-item dropdown btn-group">
                                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#" style="padding:0!important;padding-right:10px!important;">
                                                   Req. Electrónica
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'genera-req-electronica/">
                                                            Generar requisición
                                                        </a>
                                                    </li>
                                                    <!--<li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'mis-cotizaciones/">
                                                            Mis Requisiciones
                                                        </a>
                                                    </li>-->
                                                    <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'requisiciones-pendientes/">
                                                            Requisiciones Pendientes
                                                        </a>
                                                    </li>
                                                    <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'historial-req-electronica/">
                                                            Historial
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>';
                                        }else{

                        $res_kindMenu .= '   <li class="nav-item '.$OCULTA_COTIZADOR_EXPRESS.'" style="display:none!important;">
                                                <a class="nav-link" href="'.WS_ROOT.'cotizador-express/" style="padding:0!important;padding-right:10px!important;padding-top:8px!important;display:none!important;">Cotizador Exprés
                                                    <!--<i class="fa fa-caret-down" aria-hidden="true"></i>-->
                                                </a>
                                            </li>';
                                        }

                        $res_kindMenu .= '   <li class="nav-item dropdown btn-group">
                                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                                                   Opciones
                                                </a>
                                                <ul class="dropdown-menu">';

                                                if ($historial_visible == 1){
                                                $res_kindMenu .= '    <li class="dropdown">
                                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'historial-compras/">
                                                                            Historial de compras
                                                                        </a>
                                                                    </li>';
                                                }
                                    $res_kindMenu .= ' <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'carritos-guardados/">
                                                            Carritos guardados
                                                        </a>
                                                    </li>';

                                                    if ($_SESSION["USUARIO_ECOMMERCE"] == 'B2B COMPRAS'){
                                      $res_kindMenu .= '<li class="dropdown">
                                                            <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'compras-estatus/">
                                                                Estatus Compras
                                                            </a>
                                                        </li>';
                                                    }
                                   $res_kindMenu .= '<li class="dropdown '.$REPORTE_REQUISICIONES.'">
                                                        <a class="dropdown-item" tabindex="-1" role="button" data-toggle="modal" data-backdrop="static" data-target="#reporte_requisiciones">
                                                            '.$letrero_reporte.'
                                                        </a>
                                                    </li>';
                                                    if ($_SESSION["USUARIO_ECOMMERCE"] != 'B2B' && $_SESSION["USUARIO_ECOMMERCE"] != 7){
                                    $res_kindMenu .= '  <li class="dropdown">
                                                            <a  class="dropdown-item" tabindex="-1" target="_blank" href="https://maps-ws.vallen.com.mx/maps_/index/maps/'.$_SESSION["USUARIO_ID"].'/report/">
                                                                Reportes
                                                            </a>
                                                        </li>';
                                                    }
                                $res_kindMenu .= '  <li class="dropdown '.$REPORTEXSTATUS.'">
                                                        <a class="dropdown-item" tabindex="-1" role="button" data-toggle="modal" data-backdrop="static" data-target="#reporte_estatus">
                                                            Reporte por estatus
                                                        </a>
                                                    </li>
                                                    <li class="dropdown '.$AUTORIZAR_PULLTICKET.'">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'autorizaciones/">
                                                            Autorizar Solicitud
                                                        </a>
                                                    </li>
                                                    <li class="dropdown '.$ORDEN_ABIERTA.'">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'saldos-oa/">
                                                            Saldos OA 
                                                        </a>
                                                    </li>
                                                    
                                                    
                                                    
                                                    <li class="dropdown '.$SOLICITUDES.'"> <!--AQUI ES DONDE SE AGREGA EL NUEVO (por ejemplo solicitudes 2-->
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'solicitudes/">
                                                            Mis Solicitudes
                                                        </a>
                                                    </li>';






                                    if (isset($_SESSION["CONTROL_PRESUPUESTO_MODULO"]) && $_SESSION["CONTROL_PRESUPUESTO_MODULO"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'control-presupuesto/">
                                                            Control Presupuesto
                                                        </a>
                                                    </li>';
                                    }
                                    if (isset($_SESSION["CONTROL_PRESUPUESTO_XCUENTA"]) && $_SESSION["CONTROL_PRESUPUESTO_XCUENTA"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'control-presupuesto-xcta/">
                                                            Control Presupuesto Cuenta
                                                        </a>
                                                    </li>';
                                    }
                                    if (isset($_SESSION["AHORROS_CLIENTES"]) && $_SESSION["AHORROS_CLIENTES"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'ahorros_clientes/">
                                                            Ahorros
                                                        </a>
                                                    </li>';
                                    }
                                    if (isset($_SESSION["ADMINISTRACION_CLIENTE"]) && $_SESSION["ADMINISTRACION_CLIENTE"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'catalogos-cliente/">
                                                            Administración Cliente
                                                        </a>
                                                    </li>';
                                    }
                                    if (isset($_SESSION["ADMINISTRACION_SOLICITANTE"]) && $_SESSION["ADMINISTRACION_SOLICITANTE"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'catalogos-cliente-solicitante/">
                                                            Administración Solicitante
                                                        </a>
                                                    </li>';
                                    }
                                    if (isset($_SESSION["REGLA_ENTREGA_CAT"]) && $_SESSION["REGLA_ENTREGA_CAT"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'regla-entrega-categoria/">
                                                            Regla de entrega por categoría
                                                        </a>
                                                    </li>';
                                    }
                                    if (isset($_SESSION["CONSULTA_PRESUPUESTO"]) && $_SESSION["CONSULTA_PRESUPUESTO"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'consulta-presupuesto/">
                                                            Consulta de presupuesto
                                                        </a>
                                                    </li>';
                                    }
                        $res_kindMenu .= '      </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-3 text-right" id="div_login" path="'.WS_ROOT.'">
                                    '.$loginKind.'
                                </div>
                                <div class="col-md-1 text-center">
                                    <div id="forgot" url="'.encodeQueryString(array('do' => FS_LOGOUT . 'logout')).'" class="logo" style="height: 65px!important;">
                                        <a href="'.WS_ROOT.'"><img class="img-fluid" src="https://serviciosweb.vallen.com.mx/img/b2b_logos/'.$_SESSION["LOGO_CLIENTE"].'"/></a>
                                    </div>
                                </div>';

                            }else{     


                     $res_kindMenu .= '
                                <div class="col-md-3">
                                    <div id="forgot" url="'.encodeQueryString(array('do' => FS_LOGOUT . 'logout')).'" class="logo"><a href="'.$redirect_home.'"><img class="img-fluid" src="'.WS_APP_IMG.'logo-vallen-B2C.png"/></a></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="search-box">
                                        <span>
                                            <div class="busqueda-cont mt-3">    
                                                <input type="search" id="search_input" onsearch="javascript:redirect_buscador(\''.$url_cat.'\');" url="'.encodeQueryString(array('do' => FS_MOTOR_BUSQUEDA . 'motor_busqueda')).'" url_cat="'.$url_cat.'" tipo="1" autocomplete="off"/>
                                                <!--<input type="search" id="search_input" onsearch="javascript:buscadorArticulos(2,\''.$url_cat.'\');" onkeyup="javascript:buscadorArticulos(1,\''.$url_cat.'\');" url="'.encodeQueryString(array('do' => FS_MOTOR_BUSQUEDA . 'motor_busqueda')).'"/>-->
                                                <button id="btn_search" type="button" class="btn-search text-center" onclick="javascript:redirect_buscador(\''.$url_cat.'\');">
                                                    <i class="fa fa-search" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                            <ul class="busq-resultados" id="busq-resultados" style="display: none;">
                                                
                                            </ul>
                                        </span>
                                    </div>
                                    <div class="main-menu hidden-sm-down">
                                        <ul class="nav justify-content-center">
                                            <li class="nav-item dropdown btn-group">
                                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                                                   Productos
                                                </a>
                                                <ul class="dropdown-menu">
                                                    '.$dropDownCategorias.'
                                                </ul>
                                            </li>
                                            '.$CONTACTA_ESPECIALISTA.'';

                                        if ($_SESSION["COTIZADOR_ABIERTO"] == 1 && $_SESSION["USUARIO_ECOMMERCE"] != 'B2B PULLTICKET'){
                        $res_kindMenu .= '  <li class="nav-item dropdown btn-group">
                                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                                                   Cotizador Abierto
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'cotizador-abierto/">
                                                            Generar cotización
                                                        </a>
                                                    </li>
                                                    <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'mis-cotizaciones/">
                                                            Mis Cotizaciones
                                                        </a>
                                                    </li>
                                                    <!--<li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'cotizaciones-pendientes/">
                                                            Cotizaciones Pendientes
                                                        </a>
                                                    </li>-->
                                                </ul>
                                            </li>';
                                        
                                        }else if ($_SESSION["REQUISICION_ELECTRONICA"] == 1){
                                            $res_kindMenu .= '  <li class="nav-item dropdown btn-group pt-2">
                                                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#" style="padding:0!important;padding-right:10px!important;">
                                                                       Req. Electrónica
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        <li class="dropdown">
                                                                            <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'genera-req-electronica/">
                                                                                Generar requisición
                                                                            </a>
                                                                        </li>
                                                                        <!--<li class="dropdown">
                                                                            <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'mis-cotizaciones/">
                                                                                Mis Requisiciones
                                                                            </a>
                                                                        </li>-->
                                                                        <li class="dropdown">
                                                                            <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'requisiciones-pendientes/">
                                                                                Requisiciones Pendientes
                                                                            </a>
                                                                        </li>
                                                                        <li class="dropdown">
                                                                            <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'historial-req-electronica/">
                                                                                Historial
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </li>';

                                        }else {
                        $res_kindMenu .= '   <li class="nav-item '.$OCULTA_COTIZADOR_EXPRESS.'" style="display:none!important;">
                                                <a class="nav-link" href="'.WS_ROOT.'cotizador-express/" style="display:none!important;">Cotizador Exprés
                                                    <!--<i class="fa fa-caret-down" aria-hidden="true"></i>-->
                                                </a>
                                            </li>';
                                        }

                        $res_kindMenu .= '   <li class="nav-item dropdown btn-group">
                                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                                                   Opciones
                                                </a>
                                                <ul class="dropdown-menu">';
                                                if ($historial_visible == 1){
                                $res_kindMenu .= '  <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'historial-compras/">
                                                            Historial de compras
                                                        </a>
                                                    </li>';
                                                }
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'carritos-guardados/">
                                                            Carritos guardados
                                                        </a>
                                                    </li>';

                                                    if ($_SESSION["USUARIO_ECOMMERCE"] == 'B2B COMPRAS'){
                                      $res_kindMenu .= '<li class="dropdown">
                                                            <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'compras-estatus/">
                                                                Estatus Compras
                                                            </a>
                                                        </li>';
                                                    }
                                   $res_kindMenu .= '<li class="dropdown '.$REPORTE_REQUISICIONES.'">
                                                        <a class="dropdown-item" tabindex="-1" role="button" data-toggle="modal" data-backdrop="static" data-target="#reporte_requisiciones">
                                                            '.$letrero_reporte.'
                                                        </a>
                                                    </li>';
                                                    if ($_SESSION["USUARIO_ECOMMERCE"] != 'B2B' && $_SESSION["USUARIO_ECOMMERCE"] != 7){
                                    $res_kindMenu .= '  <li class="dropdown">
                                                            <a  class="dropdown-item" tabindex="-1" target="_blank" href="https://maps-ws.vallen.com.mx/maps_/index/maps/'.$_SESSION["USUARIO_ID"].'/report/">
                                                                Reportes
                                                            </a>
                                                        </li>';
                                                    }

                                 $res_kindMenu .= ' <li class="dropdown '.$REPORTEXSTATUS.'">
                                                        <a class="dropdown-item" tabindex="-1" role="button" data-toggle="modal" data-backdrop="static" data-target="#reporte_estatus">
                                                            Reporte por estatus
                                                        </a>
                                                    </li>
                                                    <li class="dropdown '.$AUTORIZAR_PULLTICKET.'">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'autorizaciones/">
                                                            Autorizar Solicitud
                                                        </a>
                                                    </li>

                                                    <li class="dropdown '.$ORDEN_ABIERTA.'">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'saldos-oa/">
                                                            Saldos OA 
                                                        </a>
                                                    </li>




                                                    <li class="dropdown '.$SOLICITUDES.'">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'tokens/">
                                                            Digital Ticket - Tokens
                                                        </a>
                                                    </li>

                                                    <li class="dropdown '.$SOLICITUDES.'">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'despachos/">
                                                            Historial de Despachos
                                                        </a>
                                                    </li>



                                                    <li class="dropdown '.$SOLICITUDES.'">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'solicitudes/">
                                                            Mis-Solicitudes
                                                        </a>
                                                    </li>';                                                  
                                    if (isset($_SESSION["CONTROL_PRESUPUESTO_MODULO"]) && $_SESSION["CONTROL_PRESUPUESTO_MODULO"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'control-presupuesto/">
                                                            Control Presupuesto
                                                        </a>
                                                    </li>';
                                    }
                                    if (isset($_SESSION["CONTROL_PRESUPUESTO_XCUENTA"]) && $_SESSION["CONTROL_PRESUPUESTO_XCUENTA"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'control-presupuesto-xcta/">
                                                            Control Presupuesto Cuenta
                                                        </a>
                                                    </li>';
                                    }
                                    if (isset($_SESSION["AHORROS_CLIENTES"]) && $_SESSION["AHORROS_CLIENTES"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'ahorros_clientes/">
                                                            Ahorros
                                                        </a>
                                                    </li>';
                                    }
                                    if (isset($_SESSION["ADMINISTRACION_CLIENTE"]) && $_SESSION["ADMINISTRACION_CLIENTE"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'catalogos-cliente/">
                                                            Administración Cliente
                                                        </a>
                                                    </li>';
                                    }
                                    if (isset($_SESSION["ADMINISTRACION_SOLICITANTE"]) && $_SESSION["ADMINISTRACION_SOLICITANTE"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'catalogos-cliente-solicitante/">
                                                            Administración Solicitante
                                                        </a>
                                                    </li>';
                                    }
                                    if (isset($_SESSION["REGLA_ENTREGA_CAT"]) && $_SESSION["REGLA_ENTREGA_CAT"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'regla-entrega-categoria/">
                                                            Regla de entrega por categoría
                                                        </a>
                                                    </li>';
                                    }
                                    if (isset($_SESSION["CONSULTA_PRESUPUESTO"]) && $_SESSION["CONSULTA_PRESUPUESTO"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'consulta-presupuesto/">
                                                            Consulta de presupuesto
                                                        </a>
                                                    </li>';
                                    }
                        $res_kindMenu .= '      </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-3 text-right" id="div_login" path="'.WS_ROOT.'">
                                    '.$loginKind.'
                                </div>
                                <!--------------------menu----------------->';
                            }
        $res_kindMenu .= '    </div>
                        </div>


                        <div class="container-fluid main-menu hidden-md-up">
                            <div class="row">
                                <div class="col-md-12">
                                    <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
                                        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                                            <i class="fa fa-bars color-white" aria-hidden="true"></i>
                                        </button>
                                        <a class="navbar-brand menu-drop" href="#">Menú</a>
                
                                        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                                            <ul class="navbar-nav mr-auto mt-2 mt-md-0 w-100">
                                                <li class="dropdown w-100">
                                                    <a href="#" class="nav-link dropdown-toggle p-l-15" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                        Productos <span class="caret"></span>
                                                    </a>       
                                                    <ul class="dropdown-menu">            
                                                        '.$dropDownCategorias.'          
                                                    </ul>    
                                                </li>
                                                '.$CONTACTA_ESPECIALISTA.'';
                                            if ($_SESSION["REQUISICION_ELECTRONICA"] == 1){
                            $res_kindMenu .= '  <li class="dropdown w-100">
                                                    <a class="nav-link dropdown-toggle p-l-15" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                                                       Req. Electrónica
                                                    </a>
                                                    <ul class="dropdown-menu">

                                                        <li class="dropdown">
                                                            <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'genera-req-electronica/">
                                                                Genera Requisición
                                                            </a>
                                                        </li>
                                                         <li class="dropdown">
                                                            <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'requisiciones-pendientes/">
                                                                Requisiciones Pendientes
                                                            </a>
                                                        </li>
                                                        <li class="dropdown">
                                                            <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'historial-req-electronica/">
                                                                Historial
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>';
                                            }

                            $res_kindMenu .= '  <li class="dropdown w-100 '.$OCULTA_COTIZADOR_EXPRESS.'" style="display:none!important;">        
                                                    <a href="'.WS_ROOT.'cotizador-express/" class="nav-link p-l-15" role="button" aria-haspopup="true" aria-expanded="false" style="display:none!important;">
                                                        Cotizador Exprés
                                                    </a>        
                                                </li>
                                                <li class="dropdown w-100">
                                                    <a class="nav-link dropdown-toggle p-l-15" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                                                       Opciones
                                                    </a>
                                                    <ul class="dropdown-menu">';
                                                    if ($historial_visible == 1){
                                    $res_kindMenu .= '  <li class="dropdown">
                                                            <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'historial-compras/">
                                                                Historial de compras
                                                            </a>
                                                        </li>';
                                                    }
                                    $res_kindMenu .= '  <li class="dropdown">
                                                            <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'carritos-guardados/">
                                                                Carritos guardados
                                                            </a>
                                                        </li>
                                                        <li class="dropdown">
                                                            <a class="dropdown-item" tabindex="-1" role="button" data-toggle="modal" data-backdrop="static" data-target="#reporte_requisiciones">
                                                                '.$letrero_reporte.'
                                                            </a>
                                                        </li>';

                                                    if ($_SESSION["USUARIO_ECOMMERCE"] != 'B2B' && $_SESSION["USUARIO_ECOMMERCE"] != 7){
                                    $res_kindMenu .= '  <li class="dropdown">
                                                            <a  class="dropdown-item" tabindex="-1" target="_blank" href="https://maps-ws.vallen.com.mx/maps_/index/maps/'.$_SESSION["USUARIO_ID"].'/report/">
                                                                Reportes
                                                            </a>
                                                        </li>';
                                                    }
                                                        

                                $res_kindMenu .= '      <li class="dropdown '.$REPORTEXSTATUS.'">
                                                            <a class="dropdown-item" tabindex="-1" role="button" data-toggle="modal" data-backdrop="static" data-target="#reporte_estatus">
                                                                Reporte por estatus
                                                            </a>
                                                        </li>
                                                        <li class="dropdown '.$AUTORIZAR_PULLTICKET.'">
                                                            <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'autorizaciones/">
                                                                Autorizar Solicitud
                                                            </a>
                                                        </li>
                                                        <li class="dropdown '.$ORDEN_ABIERTA.'">
                                                            <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'saldos-oa/">
                                                                Saldos OA 
                                                            </a>
                                                        </li>
                                                        <li class="dropdown '.$SOLICITUDES.'">
                                                            <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'solicitudes/">
                                                                Mis Solicitudes
                                                            </a>
                                                        </li>';
                                    if (isset($_SESSION["CONTROL_PRESUPUESTO_MODULO"]) && $_SESSION["CONTROL_PRESUPUESTO_MODULO"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'control-presupuesto/">
                                                            Control Presupuesto
                                                        </a>
                                                    </li>';
                                    }
                                    if (isset($_SESSION["CONTROL_PRESUPUESTO_XCUENTA"]) && $_SESSION["CONTROL_PRESUPUESTO_XCUENTA"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'control-presupuesto-xcta/">
                                                            Control Presupuesto Cuenta
                                                        </a>
                                                    </li>';
                                    }
                                    if (isset($_SESSION["AHORROS_CLIENTES"]) && $_SESSION["AHORROS_CLIENTES"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'ahorros_clientes/">
                                                            Ahorros
                                                        </a>
                                                    </li>';
                                    }
                                    if (isset($_SESSION["ADMINISTRACION_CLIENTE"]) && $_SESSION["ADMINISTRACION_CLIENTE"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'catalogos-cliente/">
                                                            Administración Cliente
                                                        </a>
                                                    </li>';
                                    }
                                    if (isset($_SESSION["ADMINISTRACION_SOLICITANTE"]) && $_SESSION["ADMINISTRACION_SOLICITANTE"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'catalogos-cliente-solicitante/">
                                                            Administración Solicitante
                                                        </a>
                                                    </li>';
                                    }
                                    if (isset($_SESSION["REGLA_ENTREGA_CAT"]) && $_SESSION["REGLA_ENTREGA_CAT"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'regla-entrega-categoria/">
                                                            Regla de entrega por categoría
                                                        </a>
                                                    </li>';
                                    }
                                    if (isset($_SESSION["CONSULTA_PRESUPUESTO"]) && $_SESSION["CONSULTA_PRESUPUESTO"] == 1){
                            $res_kindMenu .= '      <li class="dropdown">
                                                        <a  class="dropdown-item" tabindex="-1" href="'.WS_ROOT.'consulta-presupuesto/">
                                                            Consulta de presupuesto
                                                        </a>
                                                    </li>';
                                    }
                             $res_kindMenu .= '     </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </header>';
            break;
            case 2:

                $contrato_cadena=0;
                $tipo_if=0;
                if ($_SESSION[AUTORIZA_CADENA]==1){
                    $contrato_cadena=$_SESSION[CADENA_CLIENTE_ID];
                    $tipo_if=1;
                }else if ($_SESSION[ES_AUTORIZADOR]>0){
                    $tipo_if=2;
                }else{
                    $tipo_if=3;
                }
                if ($_SESSION[AUTORIZA_B2B] > 0){
                    $autoriza_b2b=1;
                }else{
                    $autoriza_b2b=0;
                }

                $res_kindMenu = '
                    <div class="modal fade" id="reporte_requisiciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="javascript:limpia_modal();"><span aria-hidden="true">&times;</span></button>
                                    <h4 id="tituloReporte" class="semi-bold">Requisiciones</h4>
                                </div>
                                <div class="modal-body body-scroll" id="body_consumos">
                                    <div id="div_fechas" class="mb-4">      
                                        <div class="row"> 
                                            <div class="col-md-5">
                                                <label>Fecha Inicial</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input class="form-control date_picker" id="fecha_inicial_rr" name="date_picker" placeholder="" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <label>Fecha Final</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input class="form-control date_picker" id="fecha_final_rr" name="date_picker" placeholder="" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label>&nbsp;</label>
                                                <button type="button" class="btn btn-primary btn-fluid" id="btn_genera_consumos" onclick="javascript:reporte_requisiones();">Consultar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive" id="table_reporte_req">
                                        <div id="div_gif_req" class="text-center"></div>
                                        <h6 class="mt-0 hide" id="req_nvendedor"></h6>
                                        <table class="table table-bordered" id="tabla_consumos" style="display:none;">
                                            <thead>
                                               <tr>
                                                   <th>Folio</th>
                                                   <th>Fecha</th>
                                                   <th id="req_vendedor">Vendedor</th>
                                                   <th>Total</th>
                                                   <th>REQ.</th>
                                                   <th>OC</th>
                                                   <th>FACTURA</th>
                                                   <th>AUT.</th>
                                               </tr>
                                            </thead>
                                            <tbody id="lista_requisiones" class="fz-12" url_reporte="'.encodeQueryString(array('do' => FS_HOME . 'reporte-requisiones')).'" url_autorizar="'.encodeQueryString(array('do' => FS_HOME . 'autorizar-requision')).'">
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="javascript:limpia_modal();">Cerrar</button>
                                </div>
                            </div>                            
                        </div>
                    </div>

                    <div class="modal fade" id="reporte_estatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="javascript:limpia_modal();"><span aria-hidden="true">&times;</span></button>
                                    <h4 id="tituloReporte" class="semi-bold">Reporte por Estatus</h4>
                                </div>
                                <div class="modal-body body-scroll" id="body_estatus">
                                    <div id="div_fechas" class="mb-4">      
                                        <div class="row"> 
                                            <div class="col-md-5">
                                                <label>Fecha Inicial</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input class="form-control date_picker" id="fecha_inicial_rs" name="date_picker" placeholder="" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <label>Fecha Final</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input class="form-control date_picker" id="fecha_final_rs" name="date_picker" placeholder="" type="text">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label>&nbsp;</label>
                                                <button type="button" class="btn btn-primary btn-fluid" id="btn_reporte_estatus" onclick="javascript:reporte_estatus('.$_SESSION[USUARIO_ID].','.$contrato_cadena.','.$tipo_if.','.$autoriza_b2b.','.$_SESSION[CLIENTE_ID].');">Consultar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="javascript:limpia_modal();">Cerrar</button>
                                </div>
                            </div>                            
                        </div>
                    </div>
                ';
            break;
            default:
            break;
        }

	 return $res_kindMenu;
    }
}
?>