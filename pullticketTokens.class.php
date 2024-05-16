<?php
	class pullticketTokens extends pdo_connector {
		public function sp_B2BPullticketTokens($data) {
			$sql = "sp_B2BPullticketTokens :opcion,:cliente_id,:usuario_id,:solicitante_id";
			$sql_result = $this->executeSPM($sql, $data);
			$row = $sql_result;
			return $row;
	    }
	}
?>