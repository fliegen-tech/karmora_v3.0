<?php
$output = shell_exec('ls -lart');
echo "<pre>$output</pre>";

#$1="BingSiteAuth.xml"



$output2 = shell_exec('pwd') ;
echo "<pre>$output2</pre>";
#echo "File Name is $1"



$cUser = shell_exec('whoami') ;
echo "$cUser" ;



$runshfile = shell_exec('/var/www/html/karmora.com/ttt.sh') ;
echo "Run Shell Script ..... $runshfile" ;



$runshfile2 = shell_exec('/var/www/html/karmora.com/ttt.sh sanisoft /var/www/html/karmora.com/public/images/purple.jpg') ;
echo "Run Shell Script 2nd time ..... $runshfile2" ;


$runtestcp =  shell_exec('/var/www/html/karmora.com/testcp.sh /var/www/html/karmora.com/public/images/purple.jpg') ;
echo "Run testcp.sh ......$runtestcp" ;

#$rscp = shell_exec('sh testcp.sh BingSiteAuth.xml')
#ehco "<pre> File ... Copied ...$rscp</pre>";


?>
