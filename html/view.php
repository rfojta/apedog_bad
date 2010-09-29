<?php
include('init.php');
include('classes/View.class.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Apedog: Reports</title>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <link href="default.css" rel="stylesheet" type="text/css" />
        <link href="images/common/favicon.png" rel="icon" type="image/png" />
        <script type="text/javascript" src="./libs/tablefilter2/paginate.min.js"></script>
        <script type="text/javascript" src="./libs/tablefilter2/tablesort.min.js"></script>
        <script type="text/javascript" src="./libs/tablefilter2/tablefilter.min.js"></script>

        <link href="./libs/tablefilter2/demo.css"       rel="stylesheet" type="text/css" />
        <link href="./libs/tablefilter2/paginate.css"   rel="stylesheet" type="text/css" />

        <!--[if IE]>
		<link href="../css/paginate-ie.css"   rel="stylesheet" type="text/css" />
		<![endif]-->

        <link href="./libs/tablefilter2/filter.css"   rel="stylesheet" type="text/css" />

        <link type="text/css" href="css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
        <script type="text/javascript" src="libs/datepickercontrol/datepickercontrol.js"></script>
        <link type="text/css" rel="stylesheet" href="libs/datepickercontrol/datepickercontrol_lnx.css" />
        <input type="hidden" id="DPC_TODAY_TEXT" value="today"/>
        <input type="hidden" id="DPC_BUTTON_TITLE" value="Open calendar..."/>
        <input type="hidden" id="DPC_MONTH_NAMES" value="['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']"/>
        <input type="hidden" id="DPC_DAY_NAMES" value="['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']"/>
        <script>
            /**
             * validate inputs before submit
             */
            function validateInputs(){
                dateInputs = document.getElementsByClassName("when");
                freeColumnInputs = document.getElementsByClassName("free");

                if(checkField(dateInputs)==false || checkField(freeColumnInputs)==false){
                    return false;
                } else {
                    return true;
                }

            }
            /**
             * check all fields in array that is not null
             * except when_from and when_to
             */
            checkField = function(ar) {
                var result = true;
                for (i = 0; i < ar.length; i++) {
                    // all fields shouldn't be null except when_from and when_to
                    alert(ar[i].name);
                    if( ar[i].name == 'when_from' || ar[i].name == 'when_to')
                        continue;
                    // alert(result);
                    result = result && (! ar[i].value == "");
                    // alert("result after: " + result);
                }
                return result;
            }
            /**
             * redefine new function for getting inputs with particular class
             */
            document.getElementsByClassName = function(cl) {
                var retnode = [];
                var myclass = new RegExp('\\b'+cl+'\\b');
                var elem = this.getElementsByTagName('*');
                for (var i = 0; i < elem.length; i++) {
                    var classes = elem[i].className;
                    if (myclass.test(classes)) retnode.push(elem[i]);
                }
                return retnode;
            };
        </script>
    </head>
    <body>
        <?php include('components/menu.php'); ?>
        <div id="content">
            <div id="colOne">
                <h2 class="section">View</h2>
                <div class="content">
                    <form method="POST" action="" id="viewForm" onSubmit="return validateInputs();">
                        <?php
                        $reports = new BSC_View($dbutil, $_GET['csfs'], $_SESSION['user'], $current_term, $_GET);
                        if (isset($_POST['posted'])) {
                            $reports->submit($_POST);
                        }
                        $reports->get_form_content( true );
                        ?>
                    </form>
                </div>
            </div>
            <div id="colTwo">
                <h2 class="section">Help</h2>
                <div class="content">
                    <?php $reports->get_help() ?>
                </div>
            </div>
            <div style="clear: both;">&nbsp;</div>
        </div>
        <?php include('components/footer.php'); ?>
    </body>
</html>
