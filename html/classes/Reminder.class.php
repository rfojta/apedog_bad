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
    protected $lc_id;

    protected $pre_query = "SELECT
            a.name AS 'area_name',
            k.name,
            u.name AS 'user',
            u.email,
            q.quarter_to
        FROM
            detail_tracking dt
            JOIN quarters q on dt.quarter = q.id
            JOIN lcs l on dt.lc = l.id
            JOIN kpis k on dt.kpi = k.id
            JOIN areas a on k.area = a.id
            JOIN users u on u.lc = l.id
        WHERE q.quarter_to = ':deadline'
          AND l.id = :lc_id
          AND dt.actual IS NULL";

    function __construct( $dbutil, $user ) {
        $this->dbutil = $dbutil;
        $lc = new LC($dbutil->dbres);
        $this->lc_id=  $lc->get_lc_by_user($user);
    }

    function check_tracking() {
        $date_format='Y/m/d';
        $today= date($date_format);
        $deadline= date ($date_format, strtotime('-25 days ' . $today ));
        $query = str_replace(':deadline', $deadline, $this->pre_query);
        $query = str_replace(':lc_id', $this->lc_id, $query);
        $rests=$this->dbutil->process_query_assoc($query);
        foreach($rests as $rest) {
            $this->send_mail($rest);
        }
    }

    function send_mail($rest) {
        $lock    = date('D, j.M Y',strtotime('+1 month' . $rest['quarter_to']));
        $to      = $rest['email'];
        $subject = 'Entering actual values into your AIESEC Performance Evaluator';
        $message = 'Hello '.$rest['user'].'\nYou probably forgot to enter value
            your LC achieved in '.$rest['name'].' in '. $rest['area_name'].'.\n
            Do not forget, this KPI will be locked on '.$lock. ' and you won´t be able to edit it then.\n
            Regards,\n
            your Apedog.';
        $headers = 'From: noreply@apedog.cz';

        echo "<br>Sending email to $to";
        mail($to, $subject, $message, $headers);
    }
}
?>
