<?php
$output = shell_exec('ls -lart');
echo "<pre>$output</pre>";
#$1="BingSiteAuth.xml"
$output2 = shell_exec('pwd') ;
echo "<pre>$output2</pre>";

#$cpfile = shell_exec('sh testcp.sh testmysql.php') ;
#echo "<pre> scp via shell script --- $cpfile</pre>" ;

#$cpfile ('scp $1 ehsan@kstaging-web02:/var/www/html/karmora.com/public');
$filename="/var/www/html/karmora.com/BingSiteAuth.xml"

#$cpfile = shell_exec('scp /var/www/html/karmora.com/BingSiteAuth.xml ehsan@kstaging-web02:/var/www/html/karmora.com/public');
#echo "<pre>File Copied Successfully with scp command $cpfile </pre>"

$resultcp = shell_exec('sh /var/www/html/karmora.com/testcp.sh') ;
echo "Lets See..."
echo $resultcp ;


#$cpfile ('scp "BingSiteAuth.xml" ehsan@kstaging-web02:/var/www/html/karmora.com/public');
#echo "<pre>File Copied Successfully $cpfile </pre>"

#$runsh = shell_exec('sh test.sh') ;
#echo "<pre> Run ShellScript $runsh</pre>" ;

#echo "File Name is $1"
?>
