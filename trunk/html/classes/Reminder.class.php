<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Class reminding by sending mail of not-entering actual values within
 * a 25 days since the end of quarter
 *
 * @author Krystof
 */
class Reminder {

	protected $dbutil;
	protected $actual_query = "SELECT
		a.name AS 'area_name',
		k.name,
		u.name AS 'user',
		u.email,
		q.quarter_from,
		q.quarter_to
		FROM
		detail_tracking dt
		JOIN quarters q on dt.quarter = q.id
		JOIN lcs l on dt.lc = l.id
		JOIN kpis k on dt.kpi = k.id
		JOIN areas a on k.area = a.id
		JOIN users u on u.lc = l.id
		WHERE q.quarter_to = ':deadline' AND u.id=':user_id'
		AND dt.actual IS NULL
		ORDER by a.name";
	protected $target_query = "SELECT
		a.name AS 'area_name',
		k.name,
		u.name AS 'user',
		u.email,
		q.quarter_from,
		q.quarter_to
		FROM
		detail_tracking dt
		JOIN quarters q on dt.quarter = q.id
		JOIN lcs l on dt.lc = l.id
		JOIN kpis k on dt.kpi = k.id
		JOIN areas a on k.area = a.id
		JOIN users u on u.lc = l.id
		WHERE q.quarter_to = ':deadline' AND u.id=':user_id'
		AND dt.target IS NULL
		ORDER by a.name";

	function __construct($dbutil) {
		$this->dbutil = $dbutil;
	}

	function check_tracking() {
		$date_format = 'Y-m-d';
		$today = date($date_format);
		$deadline = date($date_format, strtotime('-25 days ' . $today));
		$deadline2 = date($date_format, strtotime('-20 days ' . $today));
		$users = $this->get_user_list();

		foreach ($users as $user) {
			$query = str_replace(':deadline', $deadline, $this->actual_query);
			$query = str_replace(':user_id', $user['id'], $query);
			$rests = $this->dbutil->process_query_assoc($query);
			echo $user['email'].', ';
			if ($rests) {
				$this->send_actual_mail($rests);
			}

			$query = str_replace(':deadline', $deadline2, $this->target_query);
			$query = str_replace(':user_id', $user['id'], $query);
			$rests = $this->dbutil->process_query_assoc($query);
			if ($rests) {
				$this->send_target_mail($rests);
			}
		}
	}

	function send_actual_mail($rests) {
		$data = array();


		$till = date('jS F Y', strtotime($rest['quarter_to']));
		foreach ($rests as $rest) {

			$since = date('jS F Y', strtotime($rest['quarter_from']));
			$till = date('jS F Y', strtotime($rest['quarter_to']));
			$to = $rest['email'];
			$user = $rest['user'];
			$data[$rest['name']] = $rest['area_name'];
		}
		$subject = 'Apedog - achieved values: ' . $since . ' - ' . $till;
		$message = 'Hello ' . $user . '!

			You probably forgot to enter value your LC achieved since ' . $since . ' to ' . $till . ' in following KPIs: ';
		$i = 1;
		foreach ($data as $kpi => $area) {
			$message .= '
				' . $i . '. "' . $kpi . '" in "' . $area . '"';
			$i++;
		}
		$message.='

			';
		$message .= 'Do not forget, MC will lock this KPIs in few days and you wonÂ´t be able to edit it then.
			Regards,
			Your Apedog.';
		$headers = 'From: noreply@apedog.cz';
		echo $message . $to . $headers;
		if (mail($to, $subject, $message, $headers)) {
			echo 'jooooo'.$to.'\n';
		} else {
			echo 'neeee'.$to.'\n';
		}
	}

	function send_target_mail($rests) {
		$data = array();


		$till = date('jS F Y', strtotime($rest['quarter_to']));
		foreach ($rests as $rest) {

			$since = date('jS F Y', strtotime($rest['quarter_from']));
			$till = date('jS F Y', strtotime($rest['quarter_to']));
			$to = $rest['email'];
			$user = $rest['user'];
			$data[$rest['name']] = $rest['area_name'];
		}
		$subject = 'Apedog - planned values: ' . $since . ' - ' . $till;
		$message = 'Hello ' . $user . '!

			You probably forgot to enter values your LC is planning to achieve since ' . $since . ' to ' . $till . ' in following KPIs: ';
		$i = 1;
		foreach ($data as $kpi => $area) {
			$message .= '
				' . $i . '. "' . $kpi . '" in "' . $area . '"';
			$i++;
		}
		$message.='

			';
		$message .= 'Do not forget, MC will lock this KPIs in few days and you wonÂ´t be able to edit it then.
			Regards,
			Your Apedog.';
		$headers = 'From: noreply@apedog.cz';
		echo $message . $to . $headers;
		if (mail($to, $subject, $message, $headers)) {
			echo 'jooooo'.$to.'\n';
		} else {
			echo 'neeee'.$to.'\n';
		}
	}

	function get_user_list() {
		$query = 'SELECT * from users';
		$users = $this->dbutil->process_query_assoc($query);
		return $users;
	}

	function check_actions(){
		echo "
			***************Checking of actions starts**********************
			";
		$query = "
			SELECT c.name csf_name, s.name strategy_name, sa.name action_name, o.name operation_name, o.when ddl, r.name user, r.email user_email, u.email LCPemail, u.name LCPname
			FROM bsc_responsible r
			JOIN bsc_operation o ON r.id = o.responsible
			JOIN bsc_action sa ON sa.id = o.action
			JOIN bsc_strategy s ON s.id = sa.strategy
			JOIN csfs c ON s.csfs = c.id
			JOIN users u ON u.lc = s.lc
			WHERE o.when between sysdate()
			AND DATE_ADD( SYSDATE( ) , INTERVAL 1 DAY)
			AND o.status =0";

		;
		$rows = $this->dbutil->process_query_assoc($query);
		foreach ($rows as $row){
			$to  =  $row['user_email'] . ', '; 
			$to .= $row['LCPemail'];
			$user = $row['user'];
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= "To:".$row['user_email']. "\r\n";
			$headers .= "Cc:".$row['LCPemail']. "\r\n";

			$subject = 'Apedog - reminder of planned operation - '.$row['operation_name'];
			$message = "Hello " . $row['user'] . "!

You have followed operation planned:
	CSF: " . $row['csf_name'] . "
	Strategy: " . $row['strategy_name'] . "
	Strategic action: " . $row['action_name'] . "
	Operation: " . $row['operation_name'] . "

	DDL for finishing this operation is " . $row['ddl'] . " .

If you have already fulfilled the plan, please change the status here, so your LCP has track: http://praha.aiesec.cz/apedog/view.php?csfs=all

				Regards,
				Your Apedog.";
			$headers = 'From: noreply@apedog.cz';
			if (mail($to, $subject, $message, $headers)){
				echo "jj $to \n";
			} else {
				echo "nn $to \n";
			}

		}
		echo "***********Check action ends**************
			";

	}
}

?>
