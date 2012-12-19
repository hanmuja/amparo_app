<?php
	App::uses('CakeEmail', 'Network/Email');
	App::uses('EmailTemplate', 'Model');
    class CorreoComponent extends Component{
    	function send($email, $find_template_conditions, $tags_values=array(), $config="default", $cc=null, $bcc=null){
			if(!isset($find_template_conditions["EmailTemplate.active"]))
			$find_template_conditions["EmailTemplate.active"]= 1;
				
			$t_object= new EmailTemplate;
			$template= $t_object->find("first", array("conditions"=>$find_template_conditions));
			
			if($template){
				//get the tags in the subject and the message
				preg_match_all('/\[(.*?)\]/', $template['EmailTemplate']['subject'], $tags_subject);
				preg_match_all('/\[(.*?)\]/', $template['EmailTemplate']['message'], $tags_message);
				
				$subject = $template['EmailTemplate']['subject'];
				if($tags_subject){
			        foreach($tags_subject[0] as $i=>$tag) 
			        $subject = str_replace( $tag, $tags_values[$tags_subject[1][$i]] ,$subject);
				}
				
				$message = $template['EmailTemplate']['message'];    
				if($tags_message){
					foreach($tags_message[0] as $i=>$tag) 
			        $message = str_replace( $tag, $tags_values[$tags_message[1][$i]] ,$message);
				}
				
				$emails_to_send= array();
                                if(is_array($email))
                                  $emails_to_send= $email;
                                else 
                                  $emails_to_send[]= $email;
				
                                $first=true;
				foreach($emails_to_send as $email){
					$cm = new CakeEmail($config);
					$cm->emailFormat('html');
					$cm->to($email);
					if($cc && $first) $cm->cc($cc);
					if($bcc && $first) $cm->bcc($bcc);
					$cm->from(array('admin@arcadetracker.com' => 'Arcade Tracker'));
					$cm->subject($subject);
					$cm->send($message);
					$first = false;
				}
				
			}	
		}
	}
?>