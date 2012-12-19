<?php
    class UtilsComponent extends Component 
    {
        var $components= array("Session");
        
		function flash_simple($message, $type){
			$this->Session->setFlash($message, "FlashMessages/".$type);
		}
		
        function flash($item, $tipo, $plural=false)
        {
            $s= $plural?"s":"";
    		switch($tipo)
    		{
    			case "success_add":
    				$this->Session->setFlash(__("The %s has been saved.", $item), "FlashMessages/success");
    			break;
    			case "error_add":
    				$this->Session->setFlash(__("The %s could not be saved.", $item), "FlashMessages/error");
    			break;
    			case "success_update":
    				$this->Session->setFlash(__("The %s has been edited.", $item), "FlashMessages/success");
    			break;
    			case "error_update":
    				$this->Session->setFlash(__("The %s could not be edited.", $item), "FlashMessages/error");
    			break;
    			case "success_delete":
    				$this->Session->setFlash(__("The %s has been deleted.", $item), "FlashMessages/success");
    			break;
    			case "error_delete":
    				$this->Session->setFlash(__("The %s could not be deleted.", $item), "FlashMessages/error");
    			break;
				case "success_activate":
    				$this->Session->setFlash(__("The %s has been activated.", $item), "FlashMessages/success");
    			break;
    			case "error_activate":
    				$this->Session->setFlash(__("The %s could not be activated.", $item), "FlashMessages/error");
    			break;
				case "success_inactivate":
    				$this->Session->setFlash(__("The %s has been inactivated.", $item), "FlashMessages/success");
    			break;
    			case "error_inactivate":
    				$this->Session->setFlash(__("The %s could not be inactivated.", $item), "FlashMessages/error");
    			break;
    			case "error_coincidencia_password":
    				$this->Session->setFlash(__("The Passwords do not match."), "FlashMessages/error");
    			break;
    			case "error_item_invalido":
    				$this->Session->setFlash($item.":".__("Invalid Item."), "FlashMessages/error");
    			break;
    			case "error_no_existe":
    				$this->Session->setFlash($item.":".__("The Item does not exist."), "FlashMessages/error");
    			break;
				case "error_no_secret_questions":
    				$this->Session->setFlash(__("The User has not setup the secret questions. Talk to the system admin."), "FlashMessages/error");
    			break;
				case "error_invalid_username":
    				$this->Session->setFlash(__("Invalid username"), "FlashMessages/error");
    			break;
    			
				case "success_password_changed":
    				$this->Session->setFlash(__("Your Password has been reset. Check your mail to setup a New Password."), "FlashMessages/success");
    			break;
    			
    			case "error_wrong_answer":
    				$this->Session->setFlash(__("The Answers you have entered do not match."), "FlashMessages/error");
    			break;
    							
				case "success_verification":
    				$this->Session->setFlash(__("Your Account has been verified."), "FlashMessages/success");
    			break;
				
				case "error_recovery_email_not_found":
    				$this->Session->setFlash(__("The Email Address does not match the account's records. Try again."), "FlashMessages/error");
    			break;
    		};
        }

		function get_fecha_int($fecha_string, $y_pos=0, $m_pos=1, $d_pos=2)
		{
			$fecha_array= explode(" ", $fecha_string);
			
			if(count($fecha_array)==1)
			{
				$date= $fecha_array[0];
				$time= "00:00:00";
			}
			if(count($fecha_array)==2)
			list($date, $time)= $fecha_array;
			
			if(count($fecha_array)==3)
			list($date, $time, $ampm)= $fecha_array;
			
			if(!isset($ampm))
			{
				if(count(explode(":", $time))==2)
				{
					list($H, $i)= explode(":", $time);
					$s=0;
				}
				elseif (count(explode(":", $time))==3) {
					list($H, $i, $s)= explode(":", $time);	
				}	
			}
			else
			{
				$time= $this->ampm2tf($time." ".$ampm);
				list($H, $i)= explode(":", $time);
				$s=0;
			}
			
			
			$date_array= explode("-", $date);
			
			$y= $date_array[$y_pos];
			$m= $date_array[$m_pos];
			$d= $date_array[$d_pos];
                        
			return mktime($H, $i, $s, $m, $d, $y);
		}
		
		function ampm2tf($time)
		{
			list($time, $ampm)= explode(" ", $time);
			list($hour, $minutes)= explode(":", $time);
			
			$real_hour= $hour; 
                        if($ampm=="am" || $ampm=="AM")
			{
				if($hour==12)
				$real_hour= 0;
			}
			if($ampm=="pm" || $ampm=="PM")
			{
				if($hour!=12)
				$real_hour= $hour+12-0;
			}
			
			return $real_hour.":".$minutes;
		}
		
		function tf2ampm($time)
		{
			list($hour, $minutes, $seconds)= explode(":", $time);
			
			$real_hour= $hour;
			$ampm="am";
			if($hour=="00")
			$real_hour= "12";
			if($hour>12)
			{
				$real_hour= $hour-12;
				$ampm= "pm";
			}
			
			return $real_hour.":".$minutes." ".$ampm;
		}
		
		function generate_key()
		{
			return AuthComponent::password(date("Ydm iHs"));
		}
		
		/**
		 * @param int $l the length of the password
		 * @param int $c the number of capital letters the password must include
		 * @param int $n the number of numbers the password must include
		 * @param int $s the number of symbols the password must include
		 */
		function generate_password($l = 8, $c = 0, $n = 0, $s = 0) 
		{
		     // get count of all required minimum special chars
		     $count = $c + $n + $s;
		 
		     // sanitize inputs; should be self-explanatory
		     if(!is_int($l) || !is_int($c) || !is_int($n) || !is_int($s)) {
		          //trigger_error('Argument(s) not an integer', E_USER_WARNING);
		          return false;
		     }
		     elseif($l < 0 || $l > 20 || $c < 0 || $n < 0 || $s < 0) {
		          //trigger_error('Argument(s) out of range', E_USER_WARNING);
		          return false;
		     }
		     elseif($c > $l) {
		          //trigger_error('Number of password capitals required exceeds password length', E_USER_WARNING);
		          return false;
		     }
		     elseif($n > $l) {
		          //trigger_error('Number of password numerals exceeds password length', E_USER_WARNING);
		          return false;
		     }
		     elseif($s > $l) {
		          //trigger_error('Number of password capitals exceeds password length', E_USER_WARNING);
		          return false;
		     }
		     elseif($count > $l) {
		          //trigger_error('Number of password special characters exceeds specified password length', E_USER_WARNING);
		          return false;
		     }
		 
		     // all inputs clean, proceed to build password
		 
		     // change these strings if you want to include or exclude possible password characters
		     $chars = "abcdefghijklmnopqrstuvwxyz";
		     $caps = strtoupper($chars);
		     $nums = "0123456789";
		     $syms = "!@#%^&*()-+?";
			
			 $out="";
		     // build the base password of all lower-case letters
		     for($i = 0; $i < $l; $i++) 
		     {
		          $out .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		     }
		 
		     // create arrays if special character(s) required
		     if($count) {
		          // split base password to array; create special chars array
		          $tmp1 = str_split($out);
		          $tmp2 = array();
		 
		          // add required special character(s) to second array
		          for($i = 0; $i < $c; $i++) {
		               array_push($tmp2, substr($caps, mt_rand(0, strlen($caps) - 1), 1));
		          }
		          for($i = 0; $i < $n; $i++) {
		               array_push($tmp2, substr($nums, mt_rand(0, strlen($nums) - 1), 1));
		          }
		          for($i = 0; $i < $s; $i++) {
		               array_push($tmp2, substr($syms, mt_rand(0, strlen($syms) - 1), 1));
		          }
		 
		          // hack off a chunk of the base password array that's as big as the special chars array
		          $tmp1 = array_slice($tmp1, 0, $l - $count);
		          // merge special character(s) array with base password array
		          $tmp1 = array_merge($tmp1, $tmp2);
		          // mix the characters up
		          shuffle($tmp1);
		          // convert to string for output
		          $out = implode('', $tmp1);
		     }
		 
		     return $out;
		}
		
        function getSumWeek($values)
        {
          if(!$values['Week']['is_empty'])
          {
            $total_hours_week = 0;
            $total_minutes_week = 0;
            $total_mileages_week = 0;
            $total_tolls_week = 0;
            
            $return = array();
            
            foreach($values['Day'] as $day)
            {
              if(!$day['is_empty'])
              {
                /*******hours*******/
                $hours = 0;
                $minutes = 0;
                foreach($day['DailyTime'] as $daily_time)
                {
                  $hours=(int)$hours+$daily_time['hours'];
                  $minutes=(int)$minutes+$daily_time['minutes'];
                }
                $hours+=(int)($minutes/60);
                $minutes=$minutes%60;
                if($minutes==0)$minutes="00";
                
                if(strlen($minutes) == 1) $minutes = '0'.$minutes;
                $return['hours'][$day['id']] = $hours.":".$minutes;
                
                $total_hours_week+= $hours;
                $total_minutes_week+= $minutes;
                
                /**********mileages*********/
                $mileages = 0;
                foreach($day['DailyMileage'] as $daily_mileage)
                {
                  $mult = $daily_mileage['round_trip'] ? '2' : '1';
                  $find = false;
                  if(isset($daily_mileage['FromLocation']['StartMile'])):
                  foreach($daily_mileage['FromLocation']['StartMile'] as $miles)
                  {
                    if($miles['location_end'] == $daily_mileage['ToLocation']['id'])
                    {
					  $mileages+= $miles['distance'] * $mult;
                      $find = true;
                    }
                  }
                  endif;
                  if(isset($daily_mileage['FromLocation']['EndMile'])):
                  foreach($daily_mileage['FromLocation']['EndMile'] as $miles)
                  {
                    if($miles['location_start'] == $daily_mileage['ToLocation']['id'] && !$find)
                    {
                      $mileages+= $miles['distance'] * $mult;
                      $find = true;
                    }
                  }
                  endif;
                }
                $mileages+=$day['additional_mileage'];
                $return['mileages'][$day['id']] = $mileages;
                
                $total_mileages_week+= $mileages;
                
                /**********tolls***********/
                $total_tolls_week+=$day['tolls'];
              }
              else
              {
                $return['hours'][$day['id']] = '';
                $return['mileages'][$day['id']] = 0;
              }
            }
			
			$total_hours_week+=(int)($total_minutes_week/60);
            $total_minutes_week= $total_minutes_week%60;
			  
            if(strlen($total_minutes_week) == 1) $total_minutes_week = '0'.$total_minutes_week;
            $return['hours']['total'] = $total_hours_week.":".$total_minutes_week;
            $return['mileages']['total'] = $total_mileages_week;
            $return['tolls']['total'] = $total_tolls_week;
            
            return $return;
          }
          else
            return false;
        }


	/****Cost Total parts of problem*****/
	function get_total_parts($problems)
	{
		$return = array();
		$total = 0;
		foreach($problems as $problem)
		{
			$problem_id = $problem['Problem']['id'];
			if(!isset($return[$problem['Problem']['id']]))
			{
				$return[$problem_id] = 0;
			}
			
			foreach($problem['PartOrder'] as $part_order)
			{
				foreach($part_order['PartOrderComponent'] as $part_order_component)
				{
					if($part_order_component['successful'])
					{
						$total_cost = $part_order_component['cost'] * $part_order_component['units'];
						$return[$problem_id]+= $total_cost;
						$total+= $total_cost;
					}
				}
			}
		}
		
		$return['total'] = $total;
		
		return $return;
	}
	
    /**
    * Time Down of equipment
    */
    function get_time_down($problems)
    {
        $total_seconds = array();
		$total_seconds['total'] = 0;
        $return = array();
        $return['Problems'] = array();
		
		$our_of_orders_ids = out_of_order_ids();
		
		$last_problem_type_id = 0;
		
        foreach($problems as $problem)
        {
        	$total_problem = 0;
            $time_start = 0;
            
            if(in_array($problem['Problem']['first_problem_type_id'], array_keys($our_of_orders_ids)))
			{
                $time_start = $problem['Problem']['created'];
				$last_problem_type_id = $problem['Problem']['first_problem_type_id'];
			}
            
            if(!isset($return['Problems'][$problem['Problem']['id']]))
                $return['Problems'][$problem['Problem']['id']] = array();
            
            foreach($problem['ProblemSession'] as $problem_session)
            {
            	$problem_type_id = $problem_session['problem_type_id'];
				
                if($time_start == 0)
                {
                    if(in_array($problem_type_id, array_keys($our_of_orders_ids)))
                    {
                    	$last_problem_type_id = $problem_type_id;
                        $time_start = $problem_session['created'];
                    }
                }
                else
                {
                	if(!isset($return['Problems'][$problem['Problem']['id']][$last_problem_type_id]))
					{
						$return['Problems'][$problem['Problem']['id']][$last_problem_type_id] = 0;
					}
					
					if(!isset($total_seconds[$last_problem_type_id]))
					{
						$total_seconds[$last_problem_type_id] = 0;
					}
					
                    if(!in_array($problem_type_id, array_keys($our_of_orders_ids)) || (in_array($problem_type_id, array_keys($our_of_orders_ids)) && $problem_type_id != $last_problem_type_id))
                    {
                        $time_end = $problem_session['created'];
                        $to_sum = 0;
                        if($time_start < $time_end)
                        	$to_sum = $time_end - $time_start;
                        else
                        	$to_sum = $time_start - $time_end;

                        $total_seconds[$last_problem_type_id]+= $to_sum;
						$total_seconds['total']+= $to_sum;
						$total_problem+= $to_sum;
                        $return['Problems'][$problem['Problem']['id']][$last_problem_type_id]+= $to_sum;
						
						if(in_array($problem_type_id, array_keys($our_of_orders_ids)) && $problem_type_id != $last_problem_type_id)
						{
							$time_start = $time_end;
						}
						else
                        	$time_start = 0;
						
						$last_problem_type_id = $problem_type_id;
                    }
					else
					{
						$last_problem_type_id = $problem_type_id;
					}
                }
            }
            if($time_start != 0)
            {
            	if($problem['Problem']['closed'])
				{
					$time_end = $problem['Problem']['close_time'];
					$to_sum = $time_end - $time_start;
					$total_seconds['total']+= $to_sum;
					$total_problem+= $to_sum;
				}
				else
				{
					$to_sum = time() - $time_start;
					$total_seconds['total']+= $to_sum;
					$total_problem+= $to_sum;
				}
				
				if($last_problem_type_id)
				{
					if(!isset($return['Problems'][$problem['Problem']['id']][$last_problem_type_id]))
					{
						$return['Problems'][$problem['Problem']['id']][$last_problem_type_id] = 0;
					}
					
					if(!isset($total_seconds[$last_problem_type_id]))
					{
						$total_seconds[$last_problem_type_id] = 0;
					}
					
					$total_seconds[$last_problem_type_id]+= $to_sum;
                	$return['Problems'][$problem['Problem']['id']][$last_problem_type_id]+= $to_sum;
				}
            }
			$return['Problems'][$problem['Problem']['id']]['total'] = $total_problem;
        }
        $return['totals'] = $total_seconds;
        
        return $return;
    }


	function validate_email_list($list)
	{
		$return_emails = array();
		
		$list_array = $this->list_to_array($list);
		
		foreach($list_array as $email)
		{
			if($this->valid_email($email))
			{
				$return_emails[] = $email;
			}
		}
		
		return $return_emails;
	}
	
	function list_to_array($list)
	{
		$list = str_replace(' ', '', $list);
		$list_fix = str_replace('..', '.', $list);
		$list_comma = str_replace(';', ',', $list_fix);
		$list_array = explode(',', $list_comma);
		return $list_array;
	}
	
	function valid_email($email)
	{
	       
		$isValid = true;
	          
		if($this->notEmpty($email))
		{
			$atIndex = strrpos($email, "@");
		
			if(is_bool($atIndex) && !$atIndex)
			{
				$isValid = false;
			}
			else
			{
	            $domain = substr($email, $atIndex+1);
	            $local = substr($email, 0, $atIndex);
	            $localLen = strlen($local);
	            $domainLen = strlen($domain);
			   
	            if($localLen < 1 || $localLen > 64)
	            {
	                // local part length exceeded
					$isValid = false;
				}
				elseif($domainLen < 1 || $domainLen > 255)
				{
					// domain part length exceeded
					$isValid = false;
				}
				elseif($local[0] == '.' || $local[$localLen-1] == '.')
				{
					// local part starts or ends with '.'
					$isValid = false;
				}
				elseif(preg_match('/\\.\\./', $local))
				{
					// local part has two consecutive dots
					$isValid = false;
				}
				elseif(!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
				{
					// character not valid in domain part
					$isValid = false;
				}
				elseif(preg_match('/\\.\\./', $domain))
				{
					// domain part has two consecutive dots
					$isValid = false;
				}
				elseif(strpos($domain, '.') === false)
				{
					// domain part has not dots
					$isValid = false;
				}
				elseif(strpos($domain, ' ') != false)
				{
					// domain part has spaces
					$isValid = false;
				}
				elseif(strpos($local, ' ') != false)
				{
					// local part has spaces
					$isValid = false;
				}
				elseif(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local)))
				{
					// character not valid in local part unless
					// local part is quoted
					if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local)))
					{
						$isValid = false;
					}
				}
			}
		}
		else
		{
			$isValid = false;
		}
	    return $isValid;
	}

	function notEmpty($field)
	{
    	$isValid = true;
		$field = str_replace(" ", "", $field);
        if(empty($field))
        {
			$isValid = false;
        }
		return $isValid;

	}
}
?>
