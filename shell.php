<?php
echo "all is well"; exit;
//mkdir('testdir',0775);
//$dir    =   "testdir";
$cmd    =   "scp testdir/sitemap.xml ehsan@kstaging-web02:/home/ehsan/";
if(shell_exec($cmd)){
    echo "copied";
}
else {
    echo "not copied";
}