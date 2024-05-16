<?php
	class pullhistorialDespachos extends pdo_connector {
		public function sp_B2BHistorialDespachos($data) {
			$sql = "sp_B2BHistorialDespachos :opcion,:cliente_id,:usuario_id,:solicitante_id";
			$sql_result = $this->executeSPM($sql, $data);
			$row = $sql_result;
			return $row;
	    }
	}
?>