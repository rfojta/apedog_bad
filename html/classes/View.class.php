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

    function __construct($dbutil, $csfs, $user, $current_term) {
        $this->dbutil = $dbutil;
        $this->csfs = $csfs;
        $this->user = $user;
        $this->query = "select s.name strategy, s.id strategy_id, sa.name action, sa.id action_id, "
                . " o.name operation, r.name responsible, r.id responsible_id, o.when, o.status, o.id as operation_id"
                . " from bsc_strategy s right join bsc_action sa on (s.id = sa.strategy) "
                . " join bsc_operation o on (o.action = sa.id) "
                . " join bsc_responsible r on (o.responsible = r.id)";

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
        $this->query .= " and r.term = " . $this->term_id;
        $lcs = $this->dbutil->process_query_assoc($this->lc_query . "'" . $this->user . "'");
        $this->lc = $lcs['0']['lc'];
    }

    /**
     * generates html table from strategy,
     * operations, actions and responsible
     */
    function get_form_content() {
        $this->query = $this->query . " and s.lc = " . $this->lc;
        $this->rows = $this->dbutil->process_query_assoc($this->query);
        $csf_query = 'select * from csfs order by 1';
        $csfs = $this->dbutil->process_query_assoc($csf_query);
        $term_query = 'select * from terms order by 2';
        $terms = $this->dbutil->process_query_assoc($term_query);


        $this->getCsfDropDown($csfs);
        $this->get_term_section($terms);
        $this->ths = array('strategy', 'action', 'operation', 'responsible', 'when', 'status');
        $items_with_plus = array('strategy', 'action', 'operation', 'responsible');
        echo "<table id='test1' class='sortable-onload-show-4-5r rowstyle-alt no-arrow max-pages-4 paginate-10'>";
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
        }
        echo "</tr>\n";
        echo "</thead>\n";
        echo "<tbody>\n";
        if ($this->rows != null) {
            foreach ($this->rows as $row) {
                if ($row['strategy'] != null) {
                    echo "<tr";
                    if ($row['when'] < date('Y-m-d') && $row['status'] != '1') {
                        echo " class='overtime";
                    } else if ($row['status'] == '1') {
                        echo " class='done";
                    }
                    echo "'>";

                    foreach ($row as $key => $value) {
                        if ($key == 'status') {
                            echo "<td><input type=checkbox name='status-" . $row['operation_id']
                                    . (($value == 1) ? "' checked=\"checked\"" : "'") . "/></td>";
                        } else if (!preg_match('/.*\_id$/', $key)) {
                            echo "<td>" . htmlspecialchars($value);
                        }
                        echo "</td>";
                    }
                    echo "</tr>\n";
                }
            }
        }
        echo "</tbody>\n";
        echo "<tfoot id='table_footer'>";
        foreach ($this->ths as $key) {
            if ($key != 'operation_id') {
                echo "<td id='table_footer'>";
                if (in_array($key, $items_with_plus) && $key != "responsible") {
                    echo "<input type='button' value='+' onclick=\"addRow('test1','$key','$responsibles');\">";
                } else if ($key == "responsible") {
                    echo "<input type='button' value='+' onclick=\"window.open('components/popup-prompt-responsible.html','popuppage','width=250,height=200,top=200,left=200');\">";
                }
                echo "</td>";
            }
        }
        echo "</tfoot>";
        echo "</table>\n";

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
    function submit($post) {
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
                        echo 'dfsdfasdfasd-'.$this->csfs;
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
            $keysAndValues['term']=$this->term_id;
            $keysAndValues['lc']=$this->lc;
            echo $this->term_id."!!!!".$this->lc;
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

    function getCsfDropDown($csfList) {

        echo "CSF: \n";
        echo "<select name=\"csf_id\" id=\"csf_id\"\n";
        echo "onchange=\"window.location.href='" . $this->page .
                "term_id=" . $this->term_id . "&csfs='+this.value\">\n";

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

    function get_term_section($term_list) {
        echo "Select term: \n";
        echo "<select name=\"term_id\" id=\"term_id\"\n";
        echo "onchange=\"window.location.href='" . $this->page .
                "csfs=" . $this->csf_id . "&term_id='+this.value\">\n";

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

    function get_rows_for_term($table,$term_id) {
        $new_query= "select distinct t.name `".$table."`, t.id ".$table."_id "
                . "from bsc_".$table." t where term = ".$term_id.";";
        $new_rows = $this->dbutil->process_query_assoc($new_query);
        return $new_rows;
    }

    function sendNotification($op_id, $typeOfChange) {
        $query = "select c.name csf_name, s.name strategy_name, sa.name action_name, o.name operation_name, o.when ddl, r.name user, u.email LCPemail, u.name LCPname
			from bsc_responsible r join
			bsc_operations o on r.id=o.responsible join
			bsc_strategic_action sa on sa.id = o.strategic_action join
			bsc_strategy s on s.id = sa.strategy join
			csfs c on s.csfs = c.id join
			users u on u.lc = s.lc
			where o.id = " . $op_id;
        $rows = $this->rows[0];

        $to = $rows['LCPemail'];
        $user = $rows['user'];
        $subject = 'Apedog - operation status changed by ' . $user;
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
			function addRow(id,freeColumn, responsibles){
			var tbody = document.getElementById(id).getElementsByTagName("tbody")[0];
				var afterFree=0;
			var row = document.createElement("tr");
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
			input.setAttribute("class", "when");
			break;
		default:
			var input = document.createElement("select");';
            if ($th!='when' && $th!='status') {
                $options = $this->get_rows_for_term($th, $this->term_id);
//            $options = array();
                $index = 0;
                foreach ($options as $row) {

                    echo 'input.options[' . $index . '] = new Option("' . $row[$th] . '","' .$row[$th.'_id'] . '");';
                    $index++;


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

}

?>
