#!/bin/bash

source "$(cd `dirname $0` && pwd)/shelly.sh"

runScript check/autowindow blocking
runScript postprocess blocking
