<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

echo "Select term: \n";
echo "<select name=\"term_id\" id=\"term_id\"\n";
echo "onchange=\"window.location.href='planning.php?term_id='+this.value\">\n";

foreach( $terms as $term ) {
    echo "<option value=\"$term[0]\"";
    if( isset($_REQUEST['term_id']) ) {
        if( $term[0] == $_REQUEST['term_id']) {
            echo " selected ";
        }
    }

    echo ">";
    echo $term[1];
    echo "</option>\n";
}

echo "</select>\n"

?>
