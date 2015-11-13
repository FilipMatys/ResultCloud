#!/bin/bash

function swap {
    local TMPFILE=tmp.$$
    mv "$1" $TMPFILE
    mv "$2" "$1"
    mv $TMPFILE "$2"
}
. test_data.dat
TEST_FOLDER="/srv/www/corly/*"
PRODUCTION_FOLDER="/srv/www/corly-other" 
TEST_CONFIG_FILE="./corly/dao/base/Config2.xml"
CONFIG_FILE="./corly/dao/base/Config.xml"
sed "s/database=\"[a-z0-9A-Z]*\"/database=\"$DATABASE\"/g" $CONFIG_FILE > $TEST_CONFIG_FILE 
swap $TEST_CONFIG_FILE $CONFIG_FILE
RESULT=`phpunit`
swap $TEST_CONFIG_FILE $CONFIG_FILE
rm $TEST_CONFIG_FILE
if [[ $RESULT =~ FAILURES ]]
then
	echo "There is errors in tests: "
	echo "$RESULT"
else
	echo "Testing was finished with success."
	cp -r $TEST_FOLDER $PRODUCTION_FOLDER
fi

