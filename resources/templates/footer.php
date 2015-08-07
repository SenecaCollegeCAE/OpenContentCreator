<?php
    function footer($imageLocation) {
        print <<<EOF
        <div style="width: 700px; height: 100px; display: inline-block;">
        	<div style="text-align: center; padding-top: 10px;">    
            	<br/>
            	<span style="font-weight: bold;"><a href="./application/views/search.php">Search Activity</a>
           		<span style="padding: 20px;">|</span>
            	<a href="./application/views/register.php">Register</a>
            	<span style="padding: 20px;">|</span>
            	<a href="./application/views/forgotpassword.php">Forgot Password</a>
            	<span style="padding: 20px;">|</span>
            	<a href="./application/views/terms.php">Terms and Conditions</a>
            	<span style="padding: 20px;">|</span>
            	<a href="mailto:admin-occ@myseneca2.ca">Contact Us</a></span>
        	</div>
        	<div style="margin-right: 116px; padding-top: 10px;"><p style="font-size: 10pt;">Copyright &#169; 2015 Seneca College | </p></div><div style="margin-top: -32px; margin-left: 200px;"><img src="$imageLocation" height="21" width="94" /></div>
        </div>
        <br /><br />
    </body>
    </html>
EOF;
    }
    
    function viewsFooter($imageLocation) {
    	print <<<EOF
        <div style="width: 700px; height: 100px; display: inline-block;">
        	<div style="margin-right: 116px; padding-top: 10px;"><p style="font-size: 10pt;">Copyright &#169; 2015 Seneca College | </p></div><div style="margin-top: -32px; margin-left: 200px;"><img src='$imageLocation' height="21" width="94" /></div>
        </div>
        <br /><br />
    </body>
    </html>
EOF;
    }
?>