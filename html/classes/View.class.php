<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of View - view of bsc excel structure
 *
 * @author rf
 */
class BSC_View {

    //put your code here
    private $dbutil;
    private $csfs;
    private $term_id;
    private $csf_id;
    private $user;
    private $query;
    private $page;
    private $ths;
    private $rows;
    private $lc;
    private $rec_per_page;
    private $when_from;
    private $when_to;
    private $show_empty_operations;

    /**
     *
     * @param <type> $dbutil inner database class
     * @param <type> $csfs critical factor
     * @param <type> $user logged user
     * @param <type> $current_term actual term
     * @param <type> $rec_per_page records per page
     */
    function __construct($dbutil, $csfs, $user, $current_term, $get) {
        $this->dbutil = $dbutil;
        $this->csfs = $csfs;
        $this->user = $user;
        // pagination
        if(array_key_exists('rec_per_page', $get))
            $this->rec_per_page = $get['rec_per_page'];
        else
            $this->rec_per_page = 10;
        // limits on operataion when
        $this->when_from = $get['when_from'];
        $this->when_to = $get['when_to'];
        // either not defined or 0 - means false
        $this->show_empty_operations = $get['empty_op'];

        // main big query
        $this->query = "select s.name strategy, s.id strategy_id, sa.name action, sa.id action_id, \n"
                . " o.name operation, r.name responsible, r.id responsible_id, \n"
                . " o.when, o.status, o.id as operation_id \n"
                . " from bsc_strategy s left join bsc_action sa on (s.id = sa.strategy) \n"
                . " left join bsc_operation o on (" . $this->action_join() . ") \n"
                . " left join bsc_responsible r on (o.responsible = r.id) \n";

        
        // in case of now checkbox found (nor checked)
        // don't use left joins and show only appropriate operation
        // according to filters (where_from, where_to, etc.)
        if( ! $this->show_empty_operations ) {
            $this->query = str_replace( "left join", "join", $this->query );
        }

        if ($this->csfs != 'all') {
            $this->query .= " where s.csfs = " . $this->csfs;
        }

        $this->page = "view.php?";
        $this->lc_query = "select lc from users where login = ";
        if (isset($_GET['term_id'])) {
            $this->term_id = $_GET['term_id'];
        } else {
            $this->term_id = $current_term;
        }
        $this->query .= " and s.term = " . $this->term_id;
        $this->query .= " and ( r.term = " . $this->term_id . " OR r.term IS NULL)";
        $lcs = $this->dbutil->process_query_assoc($this->lc_query . "'" . $this->user . "'");
        $this->lc = $lcs['0']['lc'];
        $this->query .= " and r.lc = " . $this->lc;
        $this->query .= ' order by o.when desc';
    }

    function action_join() {
        $on_part = 'o.action = sa.id';
          // when from to filtering
        if( $this->when_from != null) {
                $on_part .= " and o.when >= '" . $this->when_from . "'";
                // $this->query .= " or o.when is null)";
        }
        if( $this->when_to!= null) {
                $on_part .= " and o.when <= '" . $this->when_to . "'";
                // $this->query .= " or o.when is null)";
        }
        return $on_part;
    }

    /**
     * generates PRE tag with content
     * @param <type> $what 
     */
 //   function debug( $what ) {
  //      echo "<pre>";
   //     print_r($what);
    //    echo "</pre>";
    //}

    /**
     * generates html table from strategy,
     * operations, actions and responsible
     */
    function get_form_content( $debug = false ) {

        $this->rows = $this->dbutil->process_query_assoc($this->query);
        if( $debug ) {
            $this->debug( $this->query );
            $this->debug( array_splice($this->rows, 0, 2) );
        }
        $csf_query = 'select * from csfs order by 1';
        $csfs = $this->dbutil->process_query_assoc($csf_query);
        $term_query = 'select * from terms order by 2';
        $terms = $this->dbutil->process_query_assoc($term_query);

        $this->getCsfDropDown($csfs);
        $this->get_term_section($terms);
        $this->getRecordsOnPageDropDrown();
        echo "<br>";
        $this->get_when_filters();
        $this->get_show_empty();
        // END OF PAGE LINK
        echo "&nbsp;<a href=\"#end_of_page\" title=\"Go to the end of page\">EOP</a>";
        $this->ths = array('strategy', 'action', 'operation', 'responsible', 'when', 'status');
        $items_with_plus = array('strategy', 'action', 'operation', 'responsible');
        echo "<table id='test1' class='sortable-onload-show-4-5r rowstyle-alt no-arrow max-pages-4 paginate-" .
            $this->rec_per_page . "'>";
        echo "<thead>\n";
        echo "<tr>\n";
        foreach ($this->ths as $key) {
            switch ($key) {
                case "strategy":
                    echo "<th class=\"sortable-text create-list datatype-text\">" . $key . "</th>";
                    break;
                case "action":
                    echo "<th class=\"sortable-text create-list datatype-text\">" . $key . "</th>";
                    break;
                case "operation":
                    echo "<th class=\"sortable-text datatype-text\">" . $key . "</th>";
                    break;
                case "responsible":
                    echo "<th class=\"sortable-text create-list datatype-text\">" . $key . "</th>";
                    break;
                case "when":
                    echo "<th class=\"sortable-date datatype-datedmy\">" . $key . "</th>";
                    break;
                default:
                    if ($key != 'operation_id') {
                        echo "<th>" . $key . "</th>";
                    }
            }
            echo "\n";
        }
        echo "</tr>\n";
        echo "</thead>\n";
        echo "<tbody>\n";
        if ($this->rows != null) {
            foreach ($this->rows as $row) {
                if ($row['strategy'] != null) {
                    echo "<tr";
                    if ($row['when'] < date('Y-m-d') && $row['status'] != '1') {
                        echo " class=\"overtime\"";
                    } else if ($row['status'] == '1') {
                        echo " class=\"done\"";
                    }
                    echo ">";

                    foreach ($row as $key => $value) {
                        if ($key == 'status') {
                            echo "<td><input type=checkbox name='status-" . $row['operation_id']
                                    . (($value == 1) ? "' checked=\"checked\"" : "'") . "/></td>\n";
                        } else if (!preg_match('/.*\_id$/', $key)) {
                            echo "<td>" . htmlspecialchars($value) . "</td>\n";
                        } else {
                           ;
                        }
                    }
                    echo "</tr>\n";
                }
            }
        }
        echo "</tbody>\n";
        echo "<tfoot id='table_footer'><tr>\n";
        foreach ($this->ths as $key) {
            if ($key != 'operation_id') {
                echo "<td id='table_footer'>\n";
                if ($key=="strategy"&& $this->csfs=='all') {
                    echo "<input type='button' value='+' disabled onclick=\"addRow('test1','$key','$responsibles');\">\n";
                }
                else if (in_array($key, $items_with_plus) && $key != "responsible") {
                    echo "<input type='button' value='+' onclick=\"addRow('test1','$key','$responsibles');\">\n";
                } else if ($key == "responsible") {
                    echo "<input type='button' value='+' onclick=\"new_responsible();\">\n";
                } else {
                    ;
                }
                echo "</td>\n";
            }
        }
        echo "</tr></tfoot>";
        echo "</table>\n";
        // END OF PAGE ANCHOR
        echo "<a name=\"end_of_page\"></a>";
        $this->javascripts();
        $this->get_submit_button();
    }

    /**
     * Builds submit button
     */
    function get_submit_button() {
        echo '<p>';
        echo '<input type="hidden" name="posted" value="1" />';
        echo '<input type=submit';
        echo ' value="Save" />';
        echo '</p>';
    }

    /**
     * handle status changes, sends emails
     */
    function submit($post, $debug = true) {
        if($debug) {
         //   echo "<pre>";
          //  print_r($post);
           // echo "</pre>\n";
        }
        $operation_ids = array();
        $new_lines = array();
        $operations = $this->dbutil->process_query_assoc($this->query);
        if ($operations != null) {
            foreach ($operations as $row) {
                $operation_ids[$row['operation_id']] = 0;
            }
        }
        foreach ($post as $key => $value) {
            $operation_id;
            if (preg_match('/^status-(\d+)$/', $key, $tokens)) {
                $operation_id = $tokens;
                $operation_ids[$operation_id[1]] = 1;
            } else if (preg_match('/^(\d+)\-free-.*$/', $key, $tokens)) {
                $new_lines[] = $tokens[1];
            }
        }
        foreach ($new_lines as $value) {
            $keysAndValues = array();
            foreach ($post as $key => $v) {
                $regex = '/^' . $value . '-free-.*$/';
                $r = '/^' . $value . '-free-/';
                $table;
                if (preg_match($regex, $key)) {
                    $table = preg_replace($r, '', $key);
                    $keysAndValues['name'] = $v;
                    if ($table=='strategy') {
                        $keysAndValues['csfs']=$this->csfs;
                    }
                }
                $regex = '/^' . $value . '-new-.*$/';
                $r = '/^' . $value . '-new-/';
                if (preg_match($regex, $key)) {
                    $k = preg_replace($r, '', $key);
                    $keysAndValues[$k] = $v;
                }
            }
            if ($table=='operation') {
                unset($keysAndValues['strategy']);
            }
            if ($keysAndValues['name']!=null) {
                $keysAndValues['term']=$this->term_id;
                $keysAndValues['lc']=$this->lc;
                $insert = "insert into bsc_$table ";
                $columns = '(';
                $values = '(';
                foreach ($keysAndValues as $c => $k) {
                    $columns .='`' . $c . '`,';
                    $values .= '\'' . $k . '\',';
                }
                $columns = eregi_replace(',$', '', $columns);
                $values = eregi_replace(',$', '', $values);
                $insert .=$columns . ') values ' . $values . ');';
                $this->dbutil->do_query($insert);
            }
        }
        foreach ($operation_ids as $op_id => $value) {

            if ($op_id != null) {
                $s = "select status from bsc_operation where id =" . $op_id;
                $old_value = $this->dbutil->process_query_assoc($s);
                $old_status = $old_value[0]['status'];
                $update;
                switch ($old_status) {
                    case 1:
                        if ($value == 0) {
                            $update = "update bsc_operation set status=0 where id = " . $op_id;
                            $this->dbutil->do_query($update);
                            $this->sendNotification($op_id, 'from "Done" to "Not Done"');
                        }
                        break;
                    case 0:
                        if ($value == 1) {
                            $update = "update bsc_operation set status=1 where id = " . $op_id;
                            $this->dbutil->do_query($update);
                            $this->sendNotification($op_id, 'from "Not Done" to "Done"');
                        }
                        break;
                    case null:
                        if ($value == 1) {
                            $update = "update bsc_operation set status=1 where id = " . $op_id;
                            $this->dbutil->do_query($update);
                            $this->sendNotification($op_id, 'from "Not Done" to "Done"');
                        }
                        break;
                    default:
                        break;
                }
            }
        }
    }

    /**
     * print simple help
     */
    function get_help() {
        echo "Columns: strategy, action, operation, responsible, deadline and status<br><br>";
        echo "Use dropdown menus or filter by typing keyword and hitting ENTER.<br>";
        echo "For numeric and date values >, <, = and ! operators are allowed.<br>";
        echo "You can sort by multiple columns using SHIFT.";
    }

    /**
     * Generates full url page for window refresh trick
     * @param <type> $param_to_replace
     */
    function page_with_params($param_to_replace) {
        $url = $this->page . "a=1";
        $param_list = array(
            'term_id' => $this->term_id,
            'csfs' => $this->csf_id,
            'rec_per_page' => $this->rec_per_page,
            'when_from' => $this->when_from,
            'when_to' => $this->when_to,
            'empty_op' => $this->show_empty_operations 
        );

        foreach( $param_list as $key => $value) {
            $url .= "&$key=";
            if( $key == $param_to_replace) {
                $url .= "'+this.value+'";
            }
            else {
                $url .= $value;
            }
        }
        return $url;
    }


    /**
     * Simplifying string to prevent types with ' and "
     * @param <type> $param_to_replace
     * @return <type>
     */
    function on_select($param_to_replace) {
        return "onSelect=\"window.location.href='" .
            $this->page_with_params($param_to_replace) . "'\"";
    }


    /**
     * Simplifying string to prevent types with ' and "
     * @param <type> $param_to_replace
     * @return <type>
     */
    function on_change($param_to_replace) {
        return "onchange=\"window.location.href='" .
            $this->page_with_params($param_to_replace) . "'\"";
    }

     /**
     * Simplifying string to prevent types with ' and "
     * @param <type> $param_to_replace
     * @return <type>
     */
    function on_click($param_to_replace) {
        return "onclick=\"window.location.href='" .
            $this->page_with_params($param_to_replace) . "'\"";
    }

    /**
     * Generates SELECT tag with some counts inside
     */
    function getRecordsOnPageDropDrown() {
        echo "Rows Per Page:\n";
        echo "<select name=\"rec_per_page\" id=\"rec_per_page\"\n";
        echo $this->on_change('rec_per_page') . ">\n";

        $options = array(10, 20, 50, 100);
        $selected = "";
        foreach( $options as $value ) {
            if( $value == $this->rec_per_page )
                $selected = "selected=\"selected\"";
            else
                $selected = "";
            echo "<option value=\"$value\" $selected>$value</option>\n";
        }
        echo "</select>";

    }

    /**
     * Generates select tag with critical factor list
     * @param <type> $csfList
     */
    function getCsfDropDown($csfList) {

        echo "CSF: \n";
        echo "<select name=\"csf_id\" id=\"csf_id\"\n";
        echo $this->on_change('csfs') . ">\n";

        echo "<option value='all'";
        if (isset($_GET['csfs'])) {
            if ('all' == $_GET['csfs']) {
                $this->csf_id = 'all';
                $this->csfs = 'all';
                echo " selected ";
            }
        } else if ('all' == $this->csf_id) {
            echo " selected ";
        }

        echo ">";
        echo 'All';
        echo "</option>\n";

        foreach ($csfList as $csf) {
            echo "<option value=\"" . $csf['id'] . "\"";
            if (isset($_GET['csfs'])) {
                if ($csf['id'] == $_GET['csfs']) {
                    $this->csf_id = $csf['id'];
                    $this->csfs = $csf['name'];
                    echo " selected ";
                }
            } else if ($csf['id'] == $this->csfs) {
                $this->csf_id = $csf['id'];
                echo " selected ";
            }

            echo ">";
            echo $csf['name'];
            echo "</option>\n";
        }

        echo "</select>\n";
    }

    /**
     * Select tag of terms with refresh trick
     * @param <type> $term_list
     */
    function get_term_section($term_list) {
        echo "Select term: \n";
        echo "<select name=\"term_id\" id=\"term_id\"\n";
        echo $this->on_change('term_id') . ">\n";

        foreach ($term_list as $term) {
            echo "<option value=\"" . $term['id'] . "\"";
            if (isset($_REQUEST['term_id'])) {
                if ($term['id'] == $_REQUEST['term_id']) {
                    $this->term_id = $term['id'];
                    echo " selected ";
                }
            } else if ($term['id'] == $this->term_id) {
                echo " selected";
            }

            echo ">";
            echo date('Y', strtotime($term['term_from'])) . '/' . date('Y', strtotime($term['term_to']));
            echo "</option>\n";
        }

        echo "</select>\n";
    }

    function get_when_filters() {
        $whens = array('when_from', 'when_to');
        foreach( $whens as $when_id) {

            echo '<input datepicker="true" id="' . $when_id . '" ';
            echo 'datepicker_format="YYYY-MM-DD" name="' . $when_id . '" ';
            echo $this->on_change($when_id);
            echo ' value="' . $this->$when_id . '"';
            echo ' notclear="" class="when" maxlength="10" isdatepicker="true">';
        }
    }

    /**
     * display checkbox for show empty operation option
     */
    function get_show_empty() {
        echo "\nShow empty strategies/actions: ";
        echo "<input type=\"checkbox\" name=\"empty_op\" ";
        if( $this->show_empty_operations ) {
            echo " checked=\"checked\" ";
        }
        echo $this->on_change('empty_op');
        echo " />\n";

    }

    function get_rows_for_term($table,$term_id) {
        $new_query= "select distinct t.name `".$table."`, t.id ".$table."_id "
                . "from bsc_".$table." t where term = ".$term_id." and t.lc=".$this->lc.";";
        $new_rows = $this->dbutil->process_query_assoc($new_query);
        return $new_rows;
    }

    function sendNotification($op_id, $typeOfChange) {
        $query = "select c.name csf_name, s.name strategy_name, sa.name action_name, o.name operation_name, o.when ddl, r.name user, u.email LCPemail, u.name LCPname
			from bsc_responsible r join
			bsc_operation o on r.id=o.responsible join
			bsc_action sa on sa.id = o.action join
			bsc_strategy s on s.id = sa.strategy join
			csfs c on s.csfs = c.id join
			users u on u.lc = s.lc
			where o.id = " . $op_id;
        $rows = $this->dbutil->process_query_assoc($query);
	$rows = $rows[0];
        $to = $rows['LCPemail'];
        $user = $rows['user'];
        $subject = 'Apedog - status of operation'.$rows['operation_name'].' changed by ' . $user;
        $message = "Hello " . $rows['LCPname'] . "!

                $user just changed status $typeOfChange for following operation:

CSF: " . $rows['csf_name'] . "
Strategy: " . $rows['strategy_name'] . "
Strategic action: " . $rows['action_name'] . "
Operation: " . $rows['operation_name'] . "

DDL for finishing this operation was " . $rows['ddl'] . " .
Regards,
Your Apedog.";
        $headers = 'From: noreply@apedog.cz';
	mail($to, $subject, $message, $headers);
    }

    /*
	 * prints all javascripts
    */

    function javascripts() {
        echo '<script>
            function new_responsible(){
            var tbody = document.getElementById("test1").getElementsByTagName("tbody")[0];
				var afterFree=0;
                        var r = document.getElementById("new_row");
                        if (r!=null){
                        tbody.removeChild(r);
                        }
                window.open("components/popup-prompt-responsible.html","popuppage","width=300,height=300,top=200,left=200");
}

			function addRow(id,freeColumn, responsibles){
			var tbody = document.getElementById(id).getElementsByTagName("tbody")[0];
				var afterFree=0;
                        var r = document.getElementById("new_row");
                        if (r!=null){
                        tbody.removeChild(r);
                        }
			var row = document.createElement("tr");
                        row.setAttribute("id","new_row");
			var from = 10000;
			var to = 99999;
			line_index = Math.floor(Math.random() * (to - from + 1) + from);
			';
        foreach ($this->ths as $th) {

            echo '
				var data1 = document.createElement("td");
				if (!afterFree){
switch ("' . $th . '")
	{
		case freeColumn:
			var input = document.createElement("input");
			input.className="free";
			input.setAttribute("id",line_index);
			if(freeColumn!="operation"){
			afterFree=1;
}
			input.setAttribute("id","free");
			name="new-"+freeColumn+"-"+line_index;
			name=line_index+"-free-"+freeColumn;
			input.setAttribute("name", name);
                        input.setAttribute("notClear", "");
			break;
		case "status":
			var input = document.createElement("input");
			input.type = "checkbox";
			name=line_index+"-new-status";
			input.setAttribute("name", name);
			break;
		case "when":
			var input = document.createElement("input");
			input.setAttribute("datepicker","true");
			input.setAttribute("id","when-"+line_index);
			input.setAttribute("datepicker_format","YYYY-MM-DD");
			name=line_index+"-new-when";
			input.setAttribute("name", name);
                        input.setAttribute("notClear", "");
			input.setAttribute("class", "when");
			break;
		default:
			var input = document.createElement("select");' . "\n";
            if ($th!='when' && $th!='status') {
                $options = $this->get_rows_for_term($th, $this->term_id);
//            $options = array();
                $index = 0;
	    if (!empty($options)){
                foreach ($options as $row) {

                    echo 'input.options[' . $index . '] = new Option("' . $this->escape($row[$th])
                        . '","' . $this->escape($row[$th.'_id']) . '");' . "\n";
                    $index++;


                }
	    } else{
		    
	    }
            }
            echo '
			name=line_index+"-new-' . $th . '";
			input.setAttribute("name", name);
			input.setAttribute("id",name);
			break;
			}
	row.appendChild(data1);
	data1.appendChild(input);
	}
';
        }
        echo '
			tbody.appendChild(row);
			if (freeColumn=="operation"){
			var el = document.getElementById(line_index+"-new-strategy");
			el.parentNode.removeChild(el);
			}
			DatePickerControl.init();
			}
			function handlePopupPrompt(parameters){
			var from = 10000;
			var to = 99999;
			line_index = Math.floor(Math.random() * (to - from + 1) + from);
			var type = "hidden";
value = "new";
name = line_index+"-free-responsible";

    var element = document.createElement("input");
    element.setAttribute("type", type);
    element.setAttribute("value", value);
    element.setAttribute("name", name);

    var form = document.getElementById("viewForm");

    form.appendChild(element);
    parameters["lc"]=' . $this->lc . ';
    parameters["term"]=' . $this->term_id . ';
			for(var i in parameters)
{
var type = "hidden";
value = parameters[i];
name = line_index+"-new-"+i;

    var element = document.createElement("input");
    element.setAttribute("type", type);
    element.setAttribute("value", value);
    element.setAttribute("name", name);

    var form = document.getElementById("viewForm");

    form.appendChild(element);
}
    form.submit();
}

</script>';
    }

    /**
     * replace " and ' with \" \'
     * @param <type> $str 
     */
    function escape( $str ) {
        return str_replace("'", "\\'", str_replace("\"", "\\\"", $str));
    }

}

?>
