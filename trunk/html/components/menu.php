<div id="header" align="right">
    <div id="menu">
        
            <?php
            if ($page=='index'||$page=='useful_links'){
                echo
                '<ul>
			<li><a href="main_page.php" title="">Home</a></li>
                        <li><a href="useful_links.php" title="">Useful Links</a></li>
		</ul>';
            }
            else {
                echo
                '<li><a href="main_page.php" title="">Home</a></li>
                <li><a href="detail_planning.php" title="">Planning</a></li>
                <li><a href="entering_values.php" title="">Entering values</a></li>
                <li><a href="reports.php" title="">Reports</a></li>
                <li><a href="index.php?logout" title="">Logout</a></li>';
            }
            ?>

       
    </div>
</div>
<div id="splash"><img src="<?php
            $src='images/';
            if ($_SESSION['country_code']!=null&&$page!='index'&&$page!='useful_links'){
                $src.='_'.$_SESSION['country_code'];
            } else {
                $src.='common';
            }
            $src.='/img02';
            if($page!='index'&&$page!='useful_links'){
                $src .= '_'.$_SESSION['user'].'.jpg';
                } else {
                    $src.='.jpg';
                }
            echo $src;
            ?>" alt="<?php echo $src; ?> is missing" width="1024" height="140" /></div>
