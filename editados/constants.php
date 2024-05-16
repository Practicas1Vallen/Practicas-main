<?php

//Se conecta con los servidores del localhost y https
function url(){
    if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }else{
        $protocol = 'http';
    }
    if($_SERVER[SERVER_NAME]=='localhost'){
        $path = $protocol . "://" . $_SERVER['HTTP_HOST'] . '/DEMO_DIGITAL/';
    }else{
        $path = $protocol . "://" . $_SERVER['HTTP_HOST'] . '/';
    }
    if(!strpos($path, '?')){
        if($_SERVER[SERVER_NAME]=='localhost'){
            $url = $protocol . "://" . $_SERVER['HTTP_HOST'] . '/DEMO_DIGITAL/';
        }else{$url = $protocol . "://" . $_SERVER['HTTP_HOST'] . '/';}
    }else{
        $needlePath = strpos($path, '?', 1);
        $url = substr ($path, 0, $needlePath);
    }
    return $url;
}

define('LF', chr(10)); //Define constante con 10 caracteres
define('CR', chr(13)); //LF = ? CF= ?
define('TAB', chr(9));
if($_SERVER[SERVER_NAME]=='localhost'){
    $_root = str_replace('\\', '/', preg_replace($_pattern, '$1', $_SERVER['APPL_PHYSICAL_PATH'])).'DEMO_DIGITAL/';  //Localhost

}else{
    $_root = str_replace('\\', '/', preg_replace($_pattern, '$1', $_SERVER['APPL_PHYSICAL_PATH'])); //producción
}

                    
$protocolo = protocolo();
$_base = url(); 
define('DOMINIOHTTPS','https://'.$_SERVER['HTTP_HOST']);
define('DOMINIOHTTP','http://'.$_SERVER['HTTP_HOST']);
define('DOMINIO',$protocolo.$_SERVER['SERVER_NAME']);
define('FS_ROOT', $_root);
define('WS_ROOT', $_base);
define('FS_CSSUSER', FS_ROOT . 'css/');
define('WS_CSSUSER', WS_ROOT . 'css/');
define('FS_FRAMEWORK', FS_ROOT . 'framework/');
define('WS_FRAMEWORK', WS_ROOT . 'framework/');
define('FS_BOOTSTRAP', FS_FRAMEWORK . 'assets/');
define('WS_BOOTSTRAP', WS_FRAMEWORK . 'assets/');
define('FS_TABLEDATA', FS_FRAMEWORK . 'datatables/');
define('WS_TABLEDATA', WS_FRAMEWORK . 'datatables/');
define('WS_JAVASCRIPT', WS_FRAMEWORK . 'js/');
define('WS_JQUERY', WS_JAVASCRIPT . 'jquery/');
define('FS_SESSIONS', FS_ROOT . 'sesiones/');
define('FS_CLASSES', FS_ROOT . 'classes/');
define('FS_CLASSES_SYSTEM', FS_FRAMEWORK . 'classes/');
define('FS_OPENPAY', FS_FRAMEWORK . 'Openpay/');
define('WS_OPENPAY', FS_FRAMEWORK . 'Openpay/');
define('FS_CSS', FS_ROOT . 'css/');
define('WS_CSS', WS_ROOT . 'css/');
define('FS_APP', FS_ROOT . 'app/');
define('WS_APP', WS_ROOT . 'app/');
define('FS_SCRIPTS', FS_ROOT . 'scripts/');
define('WS_SCRIPTS', WS_ROOT . 'scripts/');
define('FS_UPLOADS', FS_ROOT . 'uploads/');
define('WS_UPLOADS', WS_ROOT . 'uploads/');
define('FS_API', FS_APP . 'api/');
define('WS_API', WS_APP . 'api/');
define('FS_CONFIG_HOME', FS_APP . 'config/');
define('WS_CONFIG_HOME', WS_APP . 'config/');
define('FS_IMG', FS_CONFIG_HOME . 'img/');
define('WS_IMG', WS_CONFIG_HOME . 'img/');


define('FS_CONFIG', FS_APP . 'config/');
define('WS_CONFIG', WS_APP . 'config/');
define('FS_DB', FS_CONFIG . '_db/');
define('WS_DB', WS_CONFIG . '_db/');
define('FS_APP_BOOTSTRAP', FS_CONFIG . 'bootstrap/');
define('WS_APP_BOOTSTRAP', WS_CONFIG . 'bootstrap/');
define('FS_APP_CSS', FS_CONFIG . 'css/');
define('WS_APP_CSS', WS_CONFIG . 'css/');
define('FS_APP_JS', FS_CONFIG . 'js/');
define('WS_APP_JS', WS_CONFIG . 'js/');
define('FS_APP_IMG', FS_CONFIG . 'images/');
define('WS_APP_IMG', WS_CONFIG . 'images/');
define('FS_APP_IMG_CATEGORIAS', FS_APP_IMG . 'categorias/');
define('WS_APP_IMG_CATEGORIAS', WS_APP_IMG . 'categorias/');
define('FS_APP_PLUGINS', FS_CONFIG . 'plugins/');
define('WS_APP_PLUGINS', WS_CONFIG . 'plugins/');

//CONSTANTES DEL PROYECTO
define('FS_VIEWS', FS_APP . 'views/'); //FS=?
define('WS_VIEWS', WS_APP . 'views/'); // WS=?
define('FS_CATALOGO', FS_VIEWS . 'catalogo/');
define('WS_CATALOGO', WS_VIEWS . 'catalogo/');
define('FS_DETALLE', FS_VIEWS . 'detalle/');
define('WS_DETALLE', WS_VIEWS . 'detalle/');
define('FS_PROCESO_PAGO', FS_VIEWS . 'proceso-pago/');
define('WS_PROCESO_PAGO', WS_VIEWS . 'proceso-pago/');
define('FS_PROCESO_PAGO_LP', FS_VIEWS . 'proceso-pago-lp/');
define('WS_PROCESO_PAGO_LP', WS_VIEWS . 'proceso-pago-lp/');
define('FS_CHECKOUT', FS_VIEWS . 'checkout/');
define('WS_CHECKOUT', WS_VIEWS . 'checkout/');
define('FS_PERFIL', FS_VIEWS . 'perfil/');
define('WS_PERFIL', WS_VIEWS . 'perfil/');
define('FS_HOME', FS_VIEWS . 'home/');
define('WS_HOME', WS_VIEWS . 'home/');
define('FS_LOGIN', FS_VIEWS . 'login/');
define('WS_LOGIN', WS_VIEWS . 'login/');
define('FS_LOGOUT', FS_VIEWS . 'logout/');
define('WS_LOGOUT', WS_VIEWS . 'logout/');
define('FS_RECUPERAR_CONTRASENA', FS_VIEWS . 'recuperar-contrasena/');
define('WS_RECUPERAR_CONTRASENA', WS_VIEWS . 'recuperar-contrasena/');
define('FS_HISTORIA_SONEPAR', FS_VIEWS . 'historia-sonepar/');
define('WS_HISTORIA_SONEPAR', WS_VIEWS . 'historia-sonepar/');
define('FS_CARRITOS_GUARDADOS', FS_VIEWS . 'carritos-guardados/');
define('WS_CARRITOS_GUARDADOS', WS_VIEWS . 'carritos-guardados/');
define('FS_CATEGORIAS_PDF', FS_VIEWS . 'categorias-pdf/');
define('WS_CATEGORIAS_PDF', WS_VIEWS . 'categorias-pdf/');
define('FS_PRINCIPIOS', FS_VIEWS . 'principios/');
define('WS_PRINCIPIOS', WS_VIEWS . 'principios/');
define('FS_PROVEEDORES', FS_VIEWS . 'proveedores/');
define('WS_PROVEEDORES', WS_VIEWS . 'proveedores/');
define('FS_GENTE_VALLEN', FS_VIEWS . 'gente-vallen/');
define('WS_GENTE_VALLEN', WS_VIEWS . 'gente-vallen/');
define('FS_ENTORNO', FS_VIEWS . 'entorno/');
define('WS_ENTORNO', WS_VIEWS . 'entorno/');
define('FS_BOLSA_TRABAJO', FS_VIEWS . 'bolsa-trabajo/');
define('WS_BOLSA_TRABAJO', WS_VIEWS . 'bolsa-trabajo/');
define('FS_MARCA_PROPIA', FS_VIEWS . 'marca-propia/');
define('WS_MARCA_PROPIA', WS_VIEWS . 'marca-propia/');
define('FS_BLUEWAY', FS_VIEWS . 'blueway/');
define('WS_BLUEWAY', WS_VIEWS . 'blueway/');
define('FS_SERVICIOS_TECNICOS', FS_VIEWS . 'servicios-tecnicos/');
define('WS_SERVICIOS_TECNICOS', WS_VIEWS . 'servicios-tecnicos/');
define('FS_PROGRAMA_ALIANZA', FS_VIEWS . 'programa-alianza/');
define('WS_PROGRAMA_ALIANZA', WS_VIEWS . 'programa-alianza/');
define('FS_PROGRAMA_ENSITIO', FS_VIEWS . 'programa-ensitio/');
define('WS_PROGRAMA_ENSITIO', WS_VIEWS . 'programa-ensitio/');
define('FS_VALLEN_VISION', FS_VIEWS . 'vallen-vision/');
define('WS_VALLEN_VISION', WS_VIEWS . 'vallen-vision/');
define('FS_SMART_SUPPLY', FS_VIEWS . 'smart-supply/');
define('WS_SMART_SUPPLY', WS_VIEWS . 'smart-supply/');
define('FS_TERMINOS_COMPRA', FS_VIEWS . 'terminos-compra/');
define('WS_TERMINOS_COMPRA', WS_VIEWS . 'terminos-compra/');
define('FS_CONTACTO', FS_VIEWS . 'contacto/');
define('WS_CONTACTO', WS_VIEWS . 'contacto/');
define('FS_POLITICAS_REEMBOLSO', FS_VIEWS . 'politicas-reembolso/');
define('WS_POLITICAS_REEMBOLSO', WS_VIEWS . 'politicas-reembolso/');
define('FS_QUEJAS_SUGERENCIAS', FS_VIEWS . 'quejas-sugerencias/');
define('WS_QUEJAS_SUGERENCIAS', WS_VIEWS . 'quejas-sugerencias/');
define('FS_CATALOGO_PDF', FS_VIEWS . 'catalogo-pdf/');
define('WS_CATALOGO_PDF', WS_VIEWS . 'catalogo-pdf/');
define('FS_FACTURACION', FS_VIEWS . 'facturacion/');
define('WS_FACTURACION', WS_VIEWS . 'facturacion/');
define('FS_GENERA_FACT', FS_VIEWS . 'genera-factura/');
define('WS_GENERA_FACT', WS_VIEWS . 'genera-factura/');
define('FS_BLOG', FS_VIEWS . 'blog/');
define('WS_BLOG', WS_VIEWS . 'blog/');
define('FS_REGISTRO', FS_VIEWS . 'registro/');
define('WS_REGISTRO', WS_VIEWS . 'registro/');
define('FS_SUBCATEGORIAS', FS_VIEWS . 'subcategorias/');
define('WS_SUBCATEGORIAS', WS_VIEWS . 'subcategorias/');
define('FS_CATEGORIAS', FS_VIEWS . 'categorias/');
define('WS_CATEGORIAS', WS_VIEWS . 'categorias/');
define('FS_SUPER_CATEGORIAS', FS_VIEWS . 'super-categorias/');
define('WS_SUPER_CATEGORIAS', WS_VIEWS . 'super-categorias/');
define('FS_MOTOR_BUSQUEDA', FS_VIEWS . 'motor_busqueda/');
define('WS_MOTOR_BUSQUEDA', WS_VIEWS . 'motor_busqueda/');
define('FS_SUCURSALES', FS_VIEWS . 'sucursales/');
define('WS_SUCURSALES', WS_VIEWS . 'sucursales/');
define('FS_COTIZADOR_EXPRESS', FS_VIEWS . 'cotizador-express/');
define('WS_COTIZADOR_EXPRESS', WS_VIEWS . 'cotizador-express/');
define('FS_TERMINOS_USO', FS_VIEWS . 'terminos-uso/');
define('WS_TERMINOS_USO', WS_VIEWS . 'terminos-uso/');
define('FS_AVISO_PRIVACIDAD', FS_VIEWS . 'aviso-privacidad/');
define('WS_AVISO_PRIVACIDAD', WS_VIEWS . 'aviso-privacidad/');
define('FS_CONFIRMACION', FS_VIEWS . 'confirmacion/');
define('WS_CONFIRMACION', WS_VIEWS . 'confirmacion/');
define('FS_DETALLE_SERVICIOS', FS_VIEWS . 'detalle-servicios/');
define('WS_DETALLE_SERVICIOS', WS_VIEWS . 'detalle-servicios/');
define('FS_LANDING_PAGE', FS_VIEWS . 'landing-page/');
define('WS_LANDING_PAGE', WS_VIEWS . 'landing-page/');
define('FS_SALDOS_OA', FS_VIEWS . 'saldos-oa/');
define('WS_SALDOS_OA', WS_VIEWS . 'saldos-oa/');
define('FS_AUTORIZACIONES', FS_VIEWS . 'autorizaciones');
define('WS_AUTORIZACIONES', WS_VIEWS . 'autorizaciones');
define('FS_SOLICITUDES', FS_VIEWS . 'solicitudes');
define('WS_SOLICITUDES', WS_VIEWS . 'solicitudes');



define('FS_TOKENS', FS_VIEWS . 'tokens');
define('WS_TOKENS', WS_VIEWS . 'tokens');

define('FS_DESPACHOS', FS_VIEWS . 'despachos');
define('WS_DESPACHOS', WS_VIEWS . 'despachos');



define('FS_HIST_COMPRAS', FS_VIEWS . 'historial-compras/');
define('WS_HIST_COMPRAS', WS_VIEWS . 'historial-compras/');
define('FS_CARRITO', FS_VIEWS . 'carrito/');
define('WS_CARRITO', WS_VIEWS . 'carrito/');

define('FS_PROCESO_PAGOMX', FS_VIEWS . 'proceso-pagomx/');
define('WS_PROCESO_PAGOMX', WS_VIEWS . 'proceso-pagomx/');

define('FS_PROCESO_PAGOUSA', FS_VIEWS . 'proceso-pagousa/');
define('WS_PROCESO_PAGOUSA', WS_VIEWS . 'proceso-pagousa/');

define('FS_COMPRAS_ESTATUS', FS_VIEWS . 'compras-estatus/');
define('WS_COMPRAS_ESTATUS', WS_VIEWS . 'compras-estatus/');

define('FS_CONTROLLERS', FS_APP . 'controllers/');
define('WS_CONTROLLERS', WS_APP . 'controllers/');

define('FS_MODELS', FS_APP . 'models/');
define('WS_MODELS', WS_APP . 'models/');

define('FS_MODELS', FS_APP . 'models/');
define('WS_MODELS', WS_APP . 'models/');

define('FS_COTIZADOR_ABIERTO', FS_VIEWS . 'cotizador-abierto/');
define('WS_COTIZADOR_ABIERTO', WS_VIEWS . 'cotizador-abierto/');

define('FS_MIS_COTIZACIONES', FS_VIEWS . 'mis-cotizaciones/');
define('WS_MIS_COTIZACIONES', WS_VIEWS . 'mis-cotizaciones/');

define('FS_REQUISICIONES_PENDIENTES', FS_VIEWS . 'requisiciones-pendientes/');
define('WS_REQUISICIONES_PENDIENTES', WS_VIEWS . 'requisiciones-pendientes/');

define('FS_GENERA_REQELECTRONICA', FS_VIEWS . 'genera-req-electronica/');
define('WS_GENERA_REQELECTRONICA', WS_VIEWS . 'genera-req-electronica/');

define('FS_HISTORIAL_REQELECTRONICA', FS_VIEWS . 'historial-req-electronica/');
define('WS_HISTORIAL_REQELECTRONICA', WS_VIEWS . 'historial-req-electronica/');

define('FS_HOME_CATALOGS', FS_VIEWS . 'home-catalogs/');
define('WS_HOME_CATALOGS', WS_VIEWS . 'home-catalogs/');

define('FS_CONTROL_PRESUPUESTO', FS_VIEWS . 'control-presupuesto/');
define('WS_CONTROL_PRESUPUESTO', WS_VIEWS . 'control-presupuesto/');

define('IVA_GENERAL','0.16');

define('FS_CONTROL_PRESUPUESTO_XCTA', FS_VIEWS . 'control-presupuesto-xcta/');
define('WS_CONTROL_PRESUPUESTO_XCTA', WS_VIEWS . 'control-presupuesto-xcta/');

define('FS_CATALOGOS_CLIENTE', FS_VIEWS . 'catalogos-cliente/');
define('WS_CATALOGOS_CLIENTE', WS_VIEWS . 'catalogos-cliente/');

define('FS_CATALOGOS_SOLICITANTE', FS_VIEWS . 'catalogos-cliente-solicitante/');
define('WS_CATALOGOS_SOLICITANTE', WS_VIEWS . 'catalogos-cliente-solicitante/');

define('FS_AGREGAR_SOLICITANTE', FS_VIEWS . 'agregar-solicitante/');
define('WS_AGREGAR_SOLICITANTE', WS_VIEWS . 'agregar-solicitante/');

define('FS_REGLA_ENTREGA_CATEGORIA', FS_VIEWS . 'regla-entrega-categoria/');
define('WS_REGLA_ENTREGA_CATEGORIA', WS_VIEWS . 'regla-entrega-categoria/');

define('FS_CONSULTA_PRESUPUESTO', FS_VIEWS . 'consulta-presupuesto/');
define('WS_CONSULTA_PRESUPUESTO', WS_VIEWS . 'consulta-presupuesto/');

define('FS_AHORROS_CLIENTES', FS_VIEWS . 'ahorros_clientes/');
define('WS_AHORROS_CLIENTES', WS_VIEWS . 'ahorros_clientes/');

define('FS_SEGUIMIENTO_PEDIDOS', FS_VIEWS . 'seguimiento-pedidos/');
define('WS_SEGUIMIENTO_PEDIDOS', WS_VIEWS . 'seguimiento-pedidos/');

define('FS_EXCLUSIVOS_VALLEN', FS_VIEWS . 'exclusivos-vallen/');
define('WS_EXCLUSIVOS_VALLEN', WS_VIEWS . 'exclusivos-vallen/');

define('FS_CARRITO_CONSUMIBLES', FS_VIEWS . 'carrito-consumibles/');
define('WS_CARRITO_CONSUMIBLES', WS_VIEWS . 'carrito-consumibles/');

define('FS_CONSUMOS', FS_VIEWS . 'consumos/');
define('WS_CONSUMOS', WS_VIEWS . 'consumos/');

define('FS_CONSUMO_DET', FS_VIEWS . 'consumo-detalle/');
define('WS_CONSUMO_DET', WS_VIEWS . 'consumo-detalle/');

define('FS_CONTROL_PRES_WS', FS_VIEWS . 'control-presupuestal-ws/');
define('WS_CONTROL_PRES_WS', WS_VIEWS . 'control-presupuestal-ws/');
?>