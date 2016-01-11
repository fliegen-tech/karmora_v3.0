

#!/bin/bash
# Call this script with at least 3 parameters, for example
# sh scriptname 1 2 3

#echo "first parameter is : $1"
#su - ehsan

#scp $1 ehsan@kstaging-web02:/var/www/html/karmora.com/public


scp $1 ehsan@kstaging-web02:/var/www/html/karmora.com/public
#exit
#echo "Second parameter is $2"

#echo "Third parameter is $3"

exit 0
