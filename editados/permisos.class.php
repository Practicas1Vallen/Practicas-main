<?php

	class permisos {
	    public function get_permiso($permiso,$tipo_cat){
	        $permisos = $this->getPermisos($permiso,$tipo_cat);
	        return $permisos;
	    }

    	private function getPermisos($permiso,$tipo_cat){

            if ($permiso=="OCULTAR_SUCURSALES"){
                if ($_SESSION["OCULTAR_SUCURSALES"]==1){
                	$permiso_usuario="hide";
                    return $permiso_usuario;
                }else{
                	$permiso_usuario="";
                    return $permiso_usuario;
                }
            }
            if ($permiso=="MOSTRAR_LOGO" && $_SESSION["LOGO_CLIENTE"]!="0" && $tipo_cat==1){
                if ($_SESSION["MOSTRAR_LOGO"]==1){
                	$permiso_usuario='  <div class="row">
                                            <div class="col-md-12">
                                            	<div class="col-md-4 offset-md-1 text-center d-lineblock">
                                                	<img src="https://serviciosweb.vallen.com.mx/img/b2b_logos/'.$_SESSION["LOGO_CLIENTE"].'" width="60" class="img-logo">
                                            	</div>
                                            	<div class="col-md-6 d-lineblock">
                                                	<label class="loginmsg text-center img-logo" id="contrato-logo">
                                                    	Contrato: '.$_SESSION["CONTRATO_CLIENTE"].'
                                                	</label>
                                            	</div> 
                                        	</div>
                                    	</div>';
                    return $permiso_usuario;
                }else{
                	$permiso_usuario="";
                    return $permiso_usuario;
                }
            }

            if ($permiso=="DESACTIVAR_CARRITO" && $tipo_cat==1){
                if ($_SESSION["DESACTIVAR_CARRITO"]==1 && $tipo_cat==1){
                    $permiso_usuario="hide";
                    return $permiso_usuario;
                }else{
                    $permiso_usuario="";
                    return $permiso_usuario;
                }
            }

            if ($permiso=="ORDEN_ABIERTA"){
                if ($_SESSION["ORDEN_ABIERTA"]==1){
                    $permiso_usuario="";
                    return $permiso_usuario;
                }else{
                    $permiso_usuario="hide";
                    return $permiso_usuario;
                }
            }

            if ($permiso=="SOLICITUDES"){
                if ($_SESSION["FORMULARIO_PULLTICKET"]==1){
                    $permiso_usuario="";
                    return $permiso_usuario;
                }else{
                    $permiso_usuario="hide";
                    return $permiso_usuario;
                }
            }


            if ($permiso=="AUTORIZAR_PULLTICKET"){
                if ($_SESSION["AUTORIZAR_PULLTICKET"]==1){
                    $permiso_usuario="";
                    return $permiso_usuario;
                }else{
                    $permiso_usuario="hide";
                    return $permiso_usuario;
                }
            }

            if ($permiso=="CONTACTA_ESPECIALISTA"){
                if($_SESSION["CONTACTA_ESPECIALISTA"]==1){
                    if ($_SESSION["MOSTRAR_LOGO"] == 1 && $_SESSION["LOGO_CLIENTE"]!="0"){
                    	$permiso_usuario='	<li class="nav-item dropdown btn-group p-l-15">
                            					<a class="nav-link" href="'.WS_ROOT.'contacto/" style="padding:0!important;padding-right:10px!important;">Contacta Especialista</a>
                        					</li>';
                    }else{
                        $permiso_usuario='  <li class="nav-item dropdown btn-group p-l-15">
                                                <a class="nav-link" href="'.WS_ROOT.'contacto/">Contacta Especialista</a>
                                            </li>';
                    }
                    return $permiso_usuario;
                }else{
                    if ($_SESSION["MOSTRAR_LOGO"] == 1 && $_SESSION["LOGO_CLIENTE"]!="0"){
                        $permiso_usuario='  <li class="nav-item dropdown btn-group p-l-15">
                                                <a class="nav-link" href="'.WS_ROOT.'contacto/" style="padding:0!important;padding-right:10px!important;padding-top:8px!important;">Contacta Vendedor</a>
                                            </li';
                    }else{
                    	$permiso_usuario='	<li class="nav-item dropdown btn-group p-l-15">
                            					<a class="nav-link" href="'.WS_ROOT.'contacto/">Contacta Vendedor</a>
                        					</li>';
                    }
                    return $permiso_usuario;
                }
            }

            if ($permiso=="FORMULARIO_PULLTICKET"){
                if ($_SESSION["FORMULARIO_PULLTICKET"]==1){
                    $permiso_usuario=$_SESSION["FORMULARIO_PULLTICKET"];
                    return $permiso_usuario;
                }else{
                    $permiso_usuario=0;
                    return $permiso_usuario;
                }
            }

            if ($permiso=="MUESTRA_EXISTENCIAS"){
                if ($_SESSION["MUESTRA_EXISTENCIAS"]==1){
                	$permiso_usuario="";
                    return $permiso_usuario;
                }else{
                	$permiso_usuario="hide";
                    return $permiso_usuario;
                }
            }

            if ($permiso=="VALIDAR_COMPRA_MINIMA"){
                if (($_SESSION["VALIDAR_COMPRA_MINIMA"]==1 && ($tipo_cat==1 || $tipo_cat == 2)) || ($_SESSION["USUARIO_ECOMMERCE"] == "CATALOGO ABIERTO") || ($_SESSION["USUARIO_ECOMMERCE"] == "B2B COMPRAS")){
                    $permiso_usuario = "";
                    return $permiso_usuario;
                }else{
                    $permiso_usuario = "hide";
                    return $permiso_usuario;
                }
            }

            if ($permiso=="PRECIO_CATMX"){
                if ($_SESSION["PRECIO_CATMX"] > 0 && $tipo_cat==2){
                    $permiso_usuario = "";
                    return $permiso_usuario;
                }else{
                    $permiso_usuario = "hide";
                    return $permiso_usuario;
                }
            }

            if ($permiso == "MUESTRA_TIEMPO_ENTREGA"){
                if ($_SESSION["USUARIO_ECOMMERCE"] == "CATALOGO ABIERTO" || $tipo_cat==2){
                    $permiso_usuario = "";
                    return $permiso_usuario;
                }else if ($_SESSION["MUESTRA_TIEMPO_ENTREGA"]==1 && $tipo_cat==1){
                    $permiso_usuario = "";
                    return $permiso_usuario;
                }else{
                    $permiso_usuario = "hide";
                    return $permiso_usuario;
                }
            }

            if ($permiso=="MUESTRA_UNIDAD_MEDIDA"){
                if ($_SESSION["MUESTRA_UNIDAD_MEDIDA"]==1 && $tipo_cat==1){
                    $permiso_usuario = "";
                    return $permiso_usuario;
                }else{
                    $permiso_usuario = "hide";
                    return $permiso_usuario;
                }
            }

            if ($permiso=="OCULTA_PRECIO" && ($tipo_cat==1 || $tipo_cat == 2)){
                if ($_SESSION["OCULTA_PRECIO"]==1){
                    $permiso_usuario = "hide";
                    return $permiso_usuario;
                }else{
                    $permiso_usuario = "";
                    return $permiso_usuario;
                }
            }

            if ($permiso=="REPORTEXSTATUS" && ($tipo_cat==1 || $tipo_cat==2)){
                if ($_SESSION["USUARIO_ECOMMERCE"] == 'CATALOGO ABIERTO'){
                    $permiso_usuario = '';
                    return $permiso_usuario;
                }else{
                    if ($_SESSION["REPORTEXSTATUS"]==1){
                        $permiso_usuario = '';
                        return $permiso_usuario;
                    }else{
                        $permiso_usuario = "hide";
                        return $permiso_usuario;
                    }
                }
            }

            if ($permiso=="REPORTE_REQUISICIONES" && ($tipo_cat==1 || $tipo_cat == 2)){
                if ($_SESSION["USUARIO_ECOMMERCE"] == 'CATALOGO ABIERTO'){
                    $permiso_usuario = '';
                    return $permiso_usuario;
                }else{
                    if ($_SESSION["REPORTE_REQUISICIONES"]==1){
                        $permiso_usuario = '';
                        return $permiso_usuario;
                    }else{
                        $permiso_usuario = "hide";
                        return $permiso_usuario;
                    }
                }
            }

            if ($permiso=="OCULTAR_TOP_TEN"){
                if ($_SESSION["OCULTAR_TOP_TEN"]==1){
                    $permiso_usuario = 'hide';
                    return $permiso_usuario;
                }else{
                    $permiso_usuario = "";
                    return $permiso_usuario;
                }
            }

            if ($permiso=="OCULTA_COTIZADOR_EXPRESS"){
                if ($_SESSION["OCULTA_COTIZADOR_EXPRESS"]==1){
                    $permiso_usuario = 'hide';
                    return $permiso_usuario;
                }else{
                    $permiso_usuario = "";
                    return $permiso_usuario;
                }
            }
            
            if ($permiso=="OCULTA_IVA_TOTAL"){
                if ($_SESSION["OCULTA_IVA_TOTAL"]==1){
                    $permiso_usuario = 'hide';
                    return $permiso_usuario;
                }else{
                    $permiso_usuario = "";
                    return $permiso_usuario;
                }
            }

            if ($permiso=="OCULTA_CATALOGO_MX"){
                if ($_SESSION["OCULTA_CATALOGO_MX"]==1){
                    if ($_SESSION["USUARIO_ECOMMERCE"] == "CATALOGO ABIERTO"){
                        $permiso_usuario = WS_ROOT."mis-productos";
                    }else{
                        $permiso_usuario = '#';
                    }
                    return $permiso_usuario;
                }else{
                    $permiso_usuario = WS_ROOT."catalogo-vallen";
                    return $permiso_usuario;
                }
            }
            if ($permiso=="OCULTA_CATALOGO_USA"){
                if ($_SESSION["OCULTA_CATALOGO_USA"]==1){
                    if ($_SESSION["USUARIO_ECOMMERCE"] == "CATALOGO ABIERTO"){
                        $permiso_usuario = WS_ROOT."mis-productos";
                    }else{
                        $permiso_usuario = '#';
                    }
                    return $permiso_usuario;
                }else{
                    $permiso_usuario = WS_ROOT."catalogo-usa";
                    return $permiso_usuario;
                }
            }
        }	
	}
?>