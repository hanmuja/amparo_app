<?php
	include('db.php');
	
	function getPermission($url, $foreignKey, $model) {
		if (!is_array($url)){
			return false;
		}
		extract($url);
		
		//First need to get the aco for the url
		$query = 'SELECT Aco.id, Aco.alias ';
		$query .= 'FROM acos as Aco ';
		$query .= 'WHERE Aco.alias="controllers";';
		$acoBase = mysql_query($query);
		
		$acos = array();
		$parent_id = false;
		if (mysql_num_rows($acoBase)) {
			$acoBase = mysql_fetch_assoc($acoBase);
			$parent_id = $acoBase['id'];
			$acos[] = $parent_id;
			if (isset($plugin)) {
				$query = 'SELECT Aco.id, Aco.alias, Aco.parent_id ';
				$query .= 'FROM acos as Aco ';
				$query .= 'WHERE Aco.alias="'.$plugin.'" AND Aco.parent_id='.$parent_id.';';
				$acoPlugin = mysql_query($query);
				$acoPlugin = mysql_fetch_assoc($acoPlugin); 
				
				$parent_id = $acoPlugin['id'];
				$acos[] = $parent_id;
			} 
			if (isset($controller)) {
				$query = 'SELECT Aco.id, Aco.alias, Aco.parent_id ';
				$query .= 'FROM acos as Aco ';
				$query .= 'WHERE Aco.alias="'.$controller.'" AND Aco.parent_id='.$parent_id.';';
				$acoController = mysql_query($query);
				$acoController = mysql_fetch_assoc($acoController); 
				
				$parent_id = $acoController['id'];
				$acos[] = $parent_id;
			}
			if (isset($action)) {
				$query = 'SELECT Aco.id, Aco.alias, Aco.parent_id ';
				$query .= 'FROM acos as Aco ';
				$query .= 'WHERE Aco.alias="'.$action.'" AND Aco.parent_id='.$parent_id.';';
				$acoAction = mysql_query($query);
				$acoAction = mysql_fetch_assoc($acoAction); 
				
				$parent_id = $acoAction['id'];
				$acos[] = $parent_id;
			}
		}

		if (!$acos) {
			return false;
		}
		
		//We have the aco, now we need to find the aro.
		$query = 'SELECT Aro.id, Aro.model, Aro.foreign_key, Aro.parent_id ';
		$query .= 'FROM aros as Aro ';
		$query .= 'WHERE Aro.model="'.$model.'" AND Aro.foreign_key='.$foreignKey.';';
		$aro = mysql_query($query);
		$aro = mysql_fetch_assoc($aro);
		
		for ($i = count($acos); $i>0 ; $i--) {
			$aco_id = $acos[$i-1];
			//Find if there is an aros_acos with the aro and aco found
			$query = 'SELECT ArosAco.id, ArosAco.aro_id, ArosAco.aco_id, ArosAco._create ';
			$query .= 'FROM aros_acos as ArosAco ';
			$query .= 'WHERE ArosAco.aro_id="'.$aro['id'].'" AND ArosAco.aco_id='.$aco_id.';';
			
			$permission = mysql_query($query);
			if (mysql_num_rows($permission)) {
				$permission = mysql_fetch_assoc($permission);
				if ($permission['_create'] == 1) {
					return true;
				} else {
					return false;	
				}	
			} 
		}
		
		for ($i = count($acos); $i>0 ; $i--) {
			$aco_id = $acos[$i-1];
			
			$query = 'SELECT ArosAco.id, ArosAco.aro_id, ArosAco.aco_id, ArosAco._create ';
			$query .= 'FROM aros_acos as ArosAco ';
			$query .= 'WHERE ArosAco.aro_id="'.$aro['parent_id'].'" AND ArosAco.aco_id='.$aco_id.';';
			
			$permission = mysql_query($query);
			
			if (mysql_num_rows($permission)) {
				$permission = mysql_fetch_assoc($permission);
				if ($permission['_create'] == 1) {
					return true;
				} else {
					return false;	
				}
			}	
		}
	}
