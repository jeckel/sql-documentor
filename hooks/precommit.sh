#!/bin/bash
# PHP CodeSniffer pre-commit hook for git

PROJECT_DIR=`git rev-parse --show-toplevel`
CHECK_DIR=$PROJECT_DIR/src
PHPCS_BIN=$PROJECT_DIR/vendor/bin/phpcs
PHPMD_BIN=$PROJECT_DIR/vendor/bin/phpmd
PHPCS_CODING_STANDARD=PSR2
#PHPCS_CODING_STANDARD=$PROJECT_DIR/api/codestyle/phpcs-ruleset.xml
#PHPMD_RULESET=$PROJECT_DIR/api/codestyle/phpmd-ruleset.xml

PHP_CMD="docker run --rm -v ${PROJECT_DIR}:${PROJECT_DIR} --workdir ${PROJECT_DIR} -i php:5.6-cli php"

readonly BLUE_B='\033[0;34m\033[1m'
readonly GREEN_B='\033[0;32m\033[1m'
readonly ORANGE_B='\033[0;33m\033[1m'
readonly RED_B='\033[0;31m\033[1m'
readonly NC='\033[0m' # No Color
readonly WARNING='[\033[0;31m\033[1m\xE2\x9C\x97\033[0m]'
readonly SUCCESS='[\033[0;32m\033[1m\xE2\x9C\x93\033[0m]'

# Add ignore file / path
PHPCS_IGNORE=tests/_support/*

# Add exclude rules / path
#PHPCS_EXCLUDE=PHPCompatibility.PHP.DefaultTimezoneRequired,PHPCompatibility.PHP.NewFunctionArrayDereferencing

PHPCS_EXTENSIONS=php
TMP_STAGING=".tmp_staging"

# egrep compatible pattern of  files to be checked
PHPCS_FILE_PATTERN="\.(php|phtml)$"

# parse config
CONFIG_FILE=$PROJECT_DIR/hooks/config
if [ -e $CONFIG_FILE ]; then
    . $CONFIG_FILE
fi

# simple check if code sniffer is set up correctly
if [ ! -x $PHPCS_BIN ]; then
    echo "PHP CodeSniffer bin not found or executable -> $PHPCS_BIN"
    exit 1
fi

# simple check if phpmd is set up correcly
#if [ ! -x $PHPMD_BIN ]; then
#    echo "PHP MD bin not found or executable -> $PHPMD_BIN"
#    exit 1
#fi

# stolen from template file
if git rev-parse --verify HEAD > /dev/null
then
    against=HEAD
else
    # Initial commit: diff against an empty tree object
    against=4b825dc642cb6eb9a060e54bf8d69288fbee4904
fi

# this is the magic:
# retrieve all files in staging area that are added, modified or renamed
# but no deletions etc
FILES=$(git diff-index --name-only --cached --diff-filter=ACMR $against $CHECK_DIR )

if [ "$FILES" == "" ]; then
    exit 0
fi

# create temporary copy of staging area
if [ -e $TMP_STAGING ]; then
    rm -rf $TMP_STAGING
fi
mkdir $TMP_STAGING

# match files against whitelist
FILES_TO_CHECK=""
for FILE in $FILES
do
    echo "$FILE" | egrep -q "$PHPCS_FILE_PATTERN"
    RETVAL=$?
    if [ "$RETVAL" -eq "0" ]
    then
        FILES_TO_CHECK="$FILES_TO_CHECK $FILE"
    fi
done

if [ "$FILES_TO_CHECK" == "" ]; then
    printf "${GREEN_B}--> No files for CS/MD, continue${NC}\n"
    exit 0
fi

# execute the code sniffer
if [ "$PHPCS_IGNORE" != "" ]; then
    IGNORE="--ignore=$PHPCS_IGNORE"
else
    IGNORE=""
fi

if [ "$PHPCS_ENCODING" != "" ]; then
    ENCODING="--encoding=$PHPCS_ENCODING"
else
    ENCODING=""
fi

if [ "$PHPCS_EXCLUDE" != "" ]; then
    EXCLUDE="--exclude=$PHPCS_EXCLUDE"
else
    EXCLUDE=""
fi

if [ "$PHPCS_EXTENSIONS" != "" ]; then
    EXTENSIONS="--extensions=$PHPCS_EXTENSIONS"
else
    EXTENSIONS=""
fi

printf "${ORANGE_B}--> Checking files for CS/MD:${NC}\n"
tr ' ' '\n' <<< $FILES_TO_CHECK

# Copy contents of staged version of files to temporary staging area
# because we only want the staged version that will be commited and not
# the version in the working directory
STAGED_FILES=""
for FILE in $FILES_TO_CHECK
do
  ID=$(git diff-index --cached HEAD $FILE | cut -d " " -f4)

  # create staged version of file in temporary staging area with the same
  # path as the original file so that the phpcs ignore filters can be applied
  mkdir -p "$TMP_STAGING/$(dirname $FILE)"
  git cat-file blob $ID > "$TMP_STAGING/$FILE"
  STAGED_FILES="$STAGED_FILES $TMP_STAGING/$FILE"
done

OUTPUT_CS=$($PHP_CMD $PHPCS_BIN -s --standard=$PHPCS_CODING_STANDARD $EXCLUDE --runtime-set testVersion 5.2-5.5 $ENCODING $IGNORE $STAGED_FILES)
RETVAL_CS=$?

## Use phpmd file by file
#OUTPUT_MD=""
#for FILE in $STAGED_FILES
#do
#    OUTPUT_MD+=$($PHP_CMD $PHPMD_BIN $FILE text $PHPMD_RULESET | sed "s|$PROJECT_DIR\/$TMP_STAGING\/||")
#done

# delete temporary copy of staging area
rm -rf $TMP_STAGING

RETVAL=0
if [ $RETVAL_CS -ne 0 ]; then
    printf "${WARNING} ${ORANGE_B}CS Errors:${NC}"
    echo "$OUTPUT_CS"
    RETVAL=$RETVAL_CS
fi
#if [[ ! -z $OUTPUT_MD ]]; then
#    printf "${WARNING} ${ORANGE_B}MD Errors:${NC}"
#    echo "$OUTPUT_MD"
#    RETVAL=1
#fi
if [ $RETVAL -eq 0 ]; then
    printf "${SUCCESS} ${BLUE_B}Everything's ok, continue${NC}\n"
else
    printf "${WARNING} ${ORANGE_B}You need to fix this before commit again${NC}\n"
fi

exit $RETVAL
