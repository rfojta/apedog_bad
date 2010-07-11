<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of xlswriter
 *
 * @author krystof
 */
include 'libs/PHPExcel/Classes/PHPExcel.php';
include 'init.php';

$dbutil;
$lc_id;
$document;
construct();

function construct() {

//        $this->lc_id = $lc_id;
    $dokument = new PHPExcel();
    $dokument->getProperties()->setCreator("Apedog");
    $dokument->getProperties()->setLastModifiedBy("Apedog");
    echo $_SESSION['country_code'];
    getData();
    write($dokument);
    $oldExcelWriter = new PHPExcel_Writer_Excel5($dokument);
    $oldExcelWriter->save('files/xls/ukazka.xls');
//        header('Location: files/xls/ukazka.xls');
//        print ("<script>window.close();</script>");
}

function getData() {
//              $actuals[] = $this->actual_values->get_value($lc['id'], $quarter['id'], $kpi['id']);
//              $targets[] = $this->target_values->get_value($lc['id'], $quarter['id'], $kpi['id']);

    $lc_query = 'SELECT quarter_from, distinct(kpis.name), dt.actual, dt.target
        FROM detail_tracking dt join kpis on dt.kpi = kpis.id join lcs on lcs.id = dt.lc
        join quarters q on dt.quarter = q.id join terms t on q.term = t.id
        where lcs.id=9 group by kpis.id, quarter_from order by quarter_from desc;';
    $quarter_query = 'select * from quarters order by quarter_from;';


    $apedog = new Apedog($_SESSION['country_code']);
    $dbres = $apedog->dbres;
    $dbutil = new DB_Util($dbres, 0);

//              $data[] = $dbutil2->process_query_assoc($lc_query);
}

function write($dokument, $kpis) {

    $term_query = 'select * from terms order by term_from;';
    $terms = $dbutil->process_query_assoc($term_query);
    if ($lc_id == 'all') {
        $lc_query = 'select * from lcs;';
        $lcs= $dbutil->process_query_assoc($lc_query);
        foreach ($lcs as $value) {
            echo $value;
        }
        $dokument->createSheet();
    } else {
        $dokument->setActiveSheetIndex(0);
        foreach ($terms as $value) {
            foreach ($value as $v) {
                    $list = $dokument->getActiveSheet();
                    $bunka;
                    $list->setCellValue('A1', 'Ahoj');
                    $list->setCellValue('A2', 'Světe');
                
            };
        }
    }
}
?>
