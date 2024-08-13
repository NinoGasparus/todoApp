<?php  

	function resSelect($res) {
		$return = "<table>";
    		$resoult = [];
		if(mysqli_num_rows($res) == 0){
			return "Emtpy set <br>";
		}
		if ($row = mysqli_fetch_assoc($res)) {
        		$keys = array_keys($row);

		        $return .= "<tr>";
        		foreach ($keys as $key) {
            			$return .= "<th>" . htmlspecialchars($key) . "</th>";
        		}
        		$return .= "</tr>";

		        $return .= "<tr>";
        		foreach ($row as $value) {
            		$return .= "<td>" . htmlspecialchars($value) . "</td>";
        		}
        		$return .= "</tr>";
    		}

    		while ($row = mysqli_fetch_assoc($res)) {
        		$return .= "<tr>";
		        foreach ($row as $value) {
		            $return .= "<td>" . htmlspecialchars($value) . "</td>";
		        }
		        $return .= "</tr>";
		}

		$return .= "</table><br>";
		return $return;
	}

	

	function resDelete($res,$rowCount){
		$return = "Completed sucessfully, <b> $rowCount </b> rows affected.<br>";
		return $return;
	}

	function resUpdate($res, $rowCount){
		$return = "Completed sucessfully, <b> $rowCount </b> rows affected.<br>";
		return $return;
	}
	function resInsert($res, $rowCount){
		$return = "Completed sucessfully, <b> $rowCount </b> rows affected.<br>";
		return $return;
	}
	function resDrop($res, $rowCount){
		$return = "Completed sucessfully, <b> $rowCount </b> rows affected.<br>";
		return $return;
	}
	function resAlter($res, $rowCount){
		$return = "Completed sucessfully, <b> $rowCount </b> rows affected.<br>";
		return $return;
	}

	function resDescribe($res) {
    		$return = "<table>";
		$resoult = [];

    		if (mysqli_num_rows($res) == 0) {
        		return "Empty set <br>";
		}
		$return .= "<tr>";
		$return .= "<th>Field</th>";
		$return .= "<th>Type</th>";
		$return .= "<th>Null</th>";
		$return .= "<th>Key</th>";
		$return .= "<th>Default</th>";
		$return .= "<th>Extra</th>";
		$return .= "</tr>";

		while ($row = mysqli_fetch_assoc($res)) {
		    $return .= "<tr>";
		    $return .= "<td>" . htmlspecialchars($row['Field']) . "</td>";
		    $return .= "<td>" . htmlspecialchars($row['Type']) . "</td>";
		    $return .= "<td>" . htmlspecialchars($row['Null']) . "</td>";
		    $return .= "<td>" . htmlspecialchars($row['Key']) . "</td>";
		    $return .= "<td>" . htmlspecialchars($row['Default']) . "</td>";
		    $return .= "<td>" . htmlspecialchars($row['Extra']) . "</td>";
		    $return .= "</tr>";
		}
		 $return .= "</table><br>";
		return $return;
	}

