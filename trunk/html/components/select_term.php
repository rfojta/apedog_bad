<script type="text/javascript">
    function refreshWindow(source) {
        old_href = window.location.href;
        tokens = old_href.split('?');
        window.location.href = tokens[0] + "?term_id=" + source.value;
    }
</script>

<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

echo "Select term: \n";
echo "<select name=\"term_id\" id=\"term_id\"\n";
// echo "onchange=\"window.location.href='planning.php?term_id='+this.value\">\n";
echo "onchange=\"refreshWindow(this)\">\n";

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

echo "</select>\n";

return $term[0];

?>
