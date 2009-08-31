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

    protected $pre_query = "SELECT
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
    function __construct( $dbutil ) {
        $this->dbutil = $dbutil;
        $lc = new LC($dbutil->dbres);
    }

    function check_tracking() {
        $date_format='Y-m-d';
        $today= date($date_format);
        $deadline= date($date_format, strtotime('-25 days ' . $today ));
        $users=$this->get_user_list();

        foreach ($users as $user) {
            $query = str_replace(':deadline', $deadline, $this->pre_query);
            $query = str_replace(':user_id', $user['id'], $query);
            $rests=$this->dbutil->process_query_assoc($query);
            if ($rests) {
                $this->send_mail($rests);
            }
        }
    }

    function send_mail($rests) {
        $data=array();


        $till=date('jS F Y', strtotime($rest['quarter_to']));
        foreach ($rests as $rest) {

            $since=date('jS F Y', strtotime($rest['quarter_from']));
            $till=date('jS F Y', strtotime($rest['quarter_to']));
            $to=$rest['email'];
            $user=$rest['user'];
            $data[$rest['name']]=$rest['area_name'];
        }
        $subject = 'Entering actual values into your AIESEC Performance Evaluator';
        $message = 'Hello '.$user.'!<br /><br />You probably forgot to enter value
            your LC achieved since '.$since.' to '.$till.' in these KPIs: <ul>';
        foreach($data as $kpi => $area) {
            $message .= '<li>"'.$kpi.'" in "'.$area.'"</li>';
        }
        $message .= '</ul>';
        $message .= 'Do not forget, MC will lock this KPI in few days and you won´t be able to edit it then.<br />
            Regards,<br /> Your Apedog.';
        $headers = 'From: noreply@apedog.cz';

        mail($to, $subject, $message, $headers);
    }


    function get_user_list() {
        $query = 'SELECT * from users';
        $users=$this->dbutil->process_query_assoc($query);
        return $users;
    }
}
?>
