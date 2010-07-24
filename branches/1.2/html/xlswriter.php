<?php

/**
 * Description of xlswriter
 *
 * @author krystof
 */

session_cache_expire(60);
session_start();
if (!isset($_SESSION['user'])||!isset($_SESSION['country_code'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}
$info = $_SESSION['user'];
$lc = $_SESSION['user'];

include 'libs/PHPExcel/Classes/PHPExcel.php';
include('classes/Apedog.class.php');
$apedog = new Apedog($_SESSION['country_code']);
$dbres = $apedog->dbres;
include('classes/db_util.class.php');
$dbutil = new DB_Util($apedog->dbres);


construct();

function construct() {
    $dokument = new PHPExcel();
    $dokument->getProperties()->setCreator("Apedog");
    $dokument->getProperties()->setLastModifiedBy("Apedog");
       $dbutil = getData();
    write($dokument, $dbutil);
    $oldExcelWriter = new PHPExcel_Writer_Excel5($dokument);
    $time = date('Ymd_his'); // 20080613
    $oldExcelWriter->save("files/xls/current_$time.xls");
    header("Location: files/xls/current_$time.xls");
    print ("<script>window.close();</script>");
}

function getData() {


    $apedog = new Apedog($_SESSION['country_code']);
    $dbres = $apedog->dbres;
    $dbutil = new DB_Util($dbres, 0);
    return $dbutil;
//              $data[] = $dbutil2->process_query_assoc($lc_query);
}

function write($dokument, $dbutil) {
    $dokument->removeSheetByIndex(0);
    $lc_id = $_GET['l'];
    if ($lc_id == 'all' && $_SESSION['user']=='MC') {
       $lc_query = 'select * from lcs;';
        $lcs= $dbutil->process_query_assoc($lc_query);
        $i=0;
        foreach ($lcs as $lc) {
            write_list($dbutil, $dokument, $i, $lc['id'], $lc['name']);
            $i++;
        }
    } else if ($lc_id == 'all' && $_SESSION['user']!='MC'){
        echo "Unauthorized access!";
        die();
    } else {
        $lc_query = 'select id,name from lcs where lcs.id ='.$lc_id;
        $lcs= $dbutil->process_query_assoc($lc_query);
        write_list($dbutil, $dokument, 0, $lcs[0]['id'], $lcs[0]['name']);
    }
}

function write_list($dbutil,$dokument, $noOfSheet, $lc_id, $lc_name) {
    $lc_query = 'SELECT quarter_from, distinct(kpis.name), dt.actual, dt.target
        FROM detail_tracking dt join kpis on dt.kpi = kpis.id join lcs on lcs.id = dt.lc
        join quarters q on dt.quarter = q.id join terms t on q.term = t.id
        where lcs.id=9 group by kpis.id, quarter_from order by quarter_from desc;';
    $quarter_query = 'select * from quarters order by quarter_from;';
    $quarters = $dbutil->process_query_assoc($quarter_query);
   $dokument->createSheet($noOfSheet, $lc_name);
    $dokument->setActiveSheetIndex($noOfSheet);

    $term_query = 'select * from terms order by term_from;';
    $terms = $dbutil->process_query_assoc($term_query);


    $kpi_query = 'select distinct k.* from lc_kpi l join kpis k on l.kpi = k.id';
    $kpis = $dbutil->process_query_assoc($kpi_query);

    $list = $dokument->getActiveSheet();
    $let='B';
    $le=$let;
    $letter=$let;

    for ($l = 0; $l <count($terms); $l++) {

        $query = 'select count(*) from quarters where term = '.$terms[$l]['id'];
        $count = $dbutil->process_query_array($query);

        $let2=$let;
        for ($x = 1;$x<$count[0][0];$x++) {
            $let2++;
        }
        $list->mergeCells($let.'1:'.$let2.'1');
        $label=date('Y', strtotime($terms[$l]['term_from'])).'/'.date('Y', strtotime($terms[$l]['term_to']));
        $list->setCellValue($let.'1', $label);
        $let=$let2;
        $let++;
    }
    for ($p = 0; $p <count($quarters); $p++) {


//        $label= date('j.n.Y', strtotime($quarters[$p]['quarter_from'])).'-'.date('j.n.Y', strtotime($quarters[$p]['quarter_to']));
        $label = $quarters[$p]['id'];
        $list->setCellValue($le.'2', $label);

        $le++;
    }


    for ($i = 0; $i < count($kpis); $i++) {
        $row=$i+3;
        $list->setCellValue("A".$row, $kpis[$i]['id']);
        $letter='B';
        for($j=0; $j < count($quarters) ; $j++) {
            $dt_query = 'SELECT actual FROM detail_tracking dt';
            $dt_query .= " where dt.lc =".$lc_id;
            $dt_query .= " and dt.kpi =". $kpis[$i]['id'];
            $quarter_id= $list->getCell($letter.'2')->getValue();
            $dt_query .= ' and dt.quarter = '. $quarter_id;
            $actual = $dbutil->process_query_assoc($dt_query);

            $unit_query = 'SELECT name from kpi_units k';
            $unit_query .= ' where id = (select kpi_unit from kpis where kpis.id='.$kpis[$i]['id'].')';
            $unit = $dbutil->process_query_assoc($unit_query);
            if ($actual[0]['actual']!='') {
                $result=$actual[0]['actual'].' '.$unit[0]['name'];
            } else {
                $result = '';
            }

            $list->setCellValue($letter.$row, $result);
            $letter++;
        }
    }

    for ($i = 0; $i < count($kpis); $i++) {
        $row=$i+3;
        $list->setCellValue("A".$row, $kpis[$i]['name']);
    }
    $le='B';
    for ($p = 0; $p <count($quarters); $p++) {
        $label= date('j.n.Y', strtotime($quarters[$p]['quarter_from'])).'-'.date('j.n.Y', strtotime($quarters[$p]['quarter_to']));
        $list->setCellValue($le.'2', $label);
        $le++;
    }

    $list->getColumnDimension('A')->setWidth(45);

}
?>
