#!/bin/bash

SCRIPTFILE=$(readlink -f $0)
SCRIPTFOLDER=`dirname $SCRIPTFILE`

# application root path
ROOT="`dirname $SCRIPTFOLDER`"

# what is the EXE we are calling with the provided options
EXE="/usr/bin/php $ROOT/index.php"

# read / writeable's folder
VARFOLDER="$ROOT/var"

TEMPFOLDER="$VARFOLDER/tmp"
LOGFOLDER="$VARFOLDER/logs"

# where should the processors output be sent?
SHELLYLOGFILE="$LOGFOLDER/$(date '+%Y-%m-%d')-shelly-$(basename "$0" .sh).log"

# auto remove locks and logs after these times
MAXLOGAGE="7 days"
MAXLOCKAGE="4 hours"

# include the "functions" (new shell commands)
function crontabInit() {
	# let's make sure the required variables are setup
	checkIfSet SCRIPTFILE
	checkIfSet SCRIPTFOLDER

	checkIfSet ROOT

	checkIfSet EXE

	checkIfSet VARFOLDER
	checkIfSet TEMPFOLDER
	checkIfSet LOGFOLDER

	checkIfSet SHELLYLOGFILE

	checkIfSet MAXLOGAGE
	checkIfSet MAXLOCKAGE

	#echo
	#echo "EXE $EXE"
	#echo "Shelly Log $SHELLYLOGFILE"
	#echo "Application Root Path $ROOT"
	#echo "var folder $VARFOLDER"
	#echo "  temporary file folder $TEMPFOLDER"
	#echo "  logs folder $LOGFOLDER"
	#echo

	send2log "---- $SCRIPTFILE ----"

	cleanFolder "$LOGFOLDER" "$MAXLOGAGE"
}

function runScript() {
	local ENDPOINT=$1
	local BLOCKING=$2

	# make file safe name
	local FILE="$( echo $1 | sed s:/:_:g )"
	local DATETIME="$(date '+%Y-%m-%d')"

	local LOCKFILE="$TEMPFOLDER/$FILE.lock.txt"
	local SCRIPTLOGFILE="$LOGFOLDER/$DATETIME-$FILE.log"
	local EXE="$EXE $ENDPOINT"

	createLockFile "$LOCKFILE" "$ENDPOINT" "$MAXLOCKAGE"

	if [ "$?" == "1" ]; then
		# locked so exit runScript()
		return 1
	fi

	# Debug
	#echo $EXE

	if [ "$BLOCKING" == "blocking" ]; then
		# in log file
		send2log "$ENDPOINT Started Blocking" true

		# Execute & clean up not in background
		($EXE >> $SCRIPTLOGFILE ; removeLockFile "$LOCKFILE" "$ENDPOINT")
	else
		send2log "$ENDPOINT Started in Background" true

		# Execute & clean up in background
		($EXE >> $SCRIPTLOGFILE ; removeLockFile "$LOCKFILE" "$ENDPOINT")  &
	fi

	return 0
}

function durationToSeconds() {
  set -f
  normalize () { echo $1 | tr '[:upper:]' '[:lower:]' | tr -d "\"\\\'" | sed 's/ *y\(ear\)\{0,1\} */y /g; s/ *d\(ay\)\{0,1\} */d /g; s/ *h\(our\)\{0,1\} */h /g; s/ *m\(in\(ute\)\{0,1\}\)\{0,1\} */m /g; s/ *s\(ec\(ond\)\{0,1\}\)\{0,1\} */s /g; s/\([ydhms]\)s/\1/g'; }
  local value=$(normalize "$1")
  local fallback=$(normalize "$2")

  echo $value | grep -v '^[-+*/0-9ydhms ]\{0,30\}$' > /dev/null 2>&1
  if [ $? -eq 0 ]
  then
    >&2 echo Invalid duration pattern \"$value\"
  else
    if [ "$value" = "" ]; then
      [ "$fallback" != "" ] && durationToSeconds "$fallback"
    else
      sedtmpl () { echo "s/\([0-9]\+\)$1/(0\1 * $2)/g;"; }
      local template="$(sedtmpl '\( \|$\)' 1) $(sedtmpl y '365 * 86400') $(sedtmpl d 86400) $(sedtmpl h 3600) $(sedtmpl m 60) $(sedtmpl s 1) s/) *(/) + (/g;"
      echo $value | sed "$template" | bc
    fi
  fi
  set +f
}

function send2log() {
	echo "$(date) $1" >> $SHELLYLOGFILE
	#[ -z "$2" ] && : || echo "$1"
}

function cleanFolder() {
	local FOLDER=$1
	local SECONDS=$(durationToSeconds "$2")
	local FILES=$FOLDER/*

	send2log "Cleaning the folder $FOLDER of files older than $2"

	for F in $FILES
		do
			if [ `stat --format=%Y $F` -le $(( `date +%s` - $SECONDS )) ]; then
				send2log "$F removed"

				rm -f $F
			fi;

	done
}

function cleanFile() {
	local FILE=$1
	local SECONDS=$(durationToSeconds "$2")

	if test -f "$FILE"; then
		if [ `stat --format=%Y $FILE` -le $(( `date +%s` - $SECONDS )) ]; then
			send2log "Removing the file $FILE which is older than $2."

			rm -f $FILE
		fi
	fi
}

function checkIfSet() {
	local testVar="$1"

	if [ -z "${!testVar}" ]; then
		echo "** Variable $1 not set and is required **"

		/* fatal */
		exit 1
	fi;
}

function createLockFile() {
	local LOCKFILE="$1"
	local ENDPOINT="$2"
	local MAXLOCKAGE="$3"

	# delete the lock file if it's more than X old
	cleanFile "$LOCKFILE" "$MAXLOCKAGE"

	# Lock file if already exists and return 1 (fail)
	if [ -f "$LOCKFILE" ]; then
		# file & screen
		send2log "$ENDPOINT Locked on $( cat "$LOCKFILE" )" true

		return 1 # failure
	fi

	# Create the lock file
	echo $(date) >> "$LOCKFILE"

	# file & screen
	send2log "$ENDPOINT Lock file created" true

	return 0 # success
}

function removeLockFile() {
	local LOCKFILE="$1"
	local ENDPOINT="$2"

	if [ -f "$LOCKFILE" ]; then
		local SECONDS=$(($(date +%s) - $(date +%s -r $LOCKFILE)))

		rm $LOCKFILE;

		send2log "$ENDPOINT Ended. Elapsed time $(displayHumanTime $SECONDS)" true
		send2log "$ENDPOINT Lock File Removed" true
	else
		send2log "$ENDPOINT Ended." true
		send2log "$ENDPOINT Lock File Missing" true
	fi
}

function displayHumanTime() {
  local T=$1
  local D=$((T/60/60/24))
  local H=$((T/60/60%24))
  local M=$((T/60%60))
  local S=$((T%60))

  (( $D > 0 )) && printf '%d days ' $D
  (( $H > 0 )) && printf '%d hours ' $H
  (( $M > 0 )) && printf '%d minutes ' $M
  (( $D > 0 || $H > 0 || $M > 0 )) && printf 'and '

	printf '%d seconds\n' $S
}

#init
crontabInit