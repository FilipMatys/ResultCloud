#!/bin/bash

LAST_COMMIT=`git log | grep -oE "commit ([0-9a-z]+)" | awk 'BEGIN {ORS = "\n" } { print $2 }' | head -n 1`
LAST_WRITEN_COMMIT=`cat last_commit.dat`

echo "$LAST_WRITEN_COMMIT"
echo "$LAST_COMMIT"

if [ "$LAST_WRITEN_COMMIT" != "$LAST_COMMIT" ]
then
	#touch last_commit.dat
	echo "not equal"
	echo "$LAST_COMMIT" > last_commit.dat
	git pull
	bash start_test.sh
fi
