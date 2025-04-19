#!/bin/bash

CONFIG=$1
LOG=$2
STATUS=$3
ACCESS_KEY=$4
SECRET_KEY=$5
REAL_DELETE=$6

CMD="/usr/local/bin/aws-nuke -c $CONFIG --access-key-id $ACCESS_KEY --secret-access-key $SECRET_KEY"
[ "$REAL_DELETE" = "yes" ] && CMD="$CMD --no-dry-run --force"

$CMD > $LOG 2>&1
echo "done" > $STATUS
