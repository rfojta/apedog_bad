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
	private $csf_id;
	private $user;
	private $query;
	private $page;

	function __construct($dbutil, $csfs, $user) {
		$this->dbutil = $dbutil;
		$this->csfs = $csfs;
		$this->user = $user;
		$this->query = "select s.name strategy, sa.name action, "
			. " o.name operation, r.name responsible, o.when, o.status, o.id as operation_id"
			. " from bsc_strategy s join bsc_strategic_action sa on (sa.strategy = s.id) "
			. " join bsc_operations o on (o.strategic_action = sa.id) "
			. " join bsc_responsible r on (o.responsible = r.id)";
		if ($this->csfs != 'all') {
			$this->query .= " where s.csfs = " . $this->csfs;
		}

		$this->page = "view.php?";
	}

	/**
	 * generates html table from strategy,
	 * operations, actions and responsible
	 */
	function get_form_content() {


		$rows = $this->dbutil->process_query_assoc($this->query);
		$csf_query = 'select * from csfs order by 1';

		$csfs = $this->dbutil->process_query_assoc($csf_query);
		$this->getCsfDropdown($csfs);

		echo "<table id='test1' class='sortable-onload-show-4-5r rowstyle-alt no-arrow max-pages-4 paginate-10'>";
		if ($rows != null) {
			echo "<thead>\n";
			echo "<tr>\n";
			foreach ($rows[0] as $key => $value) {
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
			foreach ($rows as $row) {
				echo "<tr>";
				foreach ($row as $key => $value) {
					if ($key == 'status') {
						echo "<td><input type=checkbox name='status-" . $row['operation_id']
						. (($value == 1) ? "' checked=\"checked\"" : "'") . "/></td>";
					} else if ($key != 'operation_id')
						echo "<td>" . htmlspecialchars($value) . "</td>";
				}
				echo "</tr>\n";
			}
		}
		echo "</table>\n";

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
	 * handle status changes
	 */
	function submit($post) {
		foreach ($post as $key => $value) {
			echo $key . "--" . $value;
		}
		$operation_ids = array();
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
			}
		}
		foreach ($operation_ids as $op_id => $value) {

			echo "op_id".$op_id."->"."$value";
			$s = "select status from bsc_operations where id =" . $op_id;
			$old_value = $this->dbutil->process_query_assoc($s);
			$old_status = $old_value[0]['status'];
			echo "old:".$old_status;
			switch ($old_status) {
				case 1:
					if ($value == 0) {
						echo "z jedna na nula!";
					}
					break;
				case 0:
					if ($value == 1) {

						echo "z nula na jedna!";
					}
					break;
				case null:
					if ($value == 1) {
						echo "z nic na 1!";
					}
					break;
				default: echo "niccc";
					break;
			}
		}
		$actual_statuses = $this->dbutil->process_query_assoc($s);

		$update = "update bsc_operations set status=0 where id in (
			) and status = 1 where id in (
			)";
	}

	/**
	 * print simple help
	 */
	function get_help() {
		echo "Columns: strategy, action, operation, responsible, deadline and status<br><br>";
		echo "Use dropdown menus or filter by typing keyword and hitting ENTER.<br>";
		echo "For numeric and date values >, <, = and ! operators are allowed.";
	}

	function getCsfDropDown($csfList) {

		echo "CSF: \n";
		echo "<select name=\"csf_id\" id=\"csf_id\"\n";
		echo "onchange=\"window.location.href='" . $this->page .
		"csfs='+this.value\">\n";

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

}

?>
