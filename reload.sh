#!/usr/bin/env bash
#bin/console c:c
bin/console d:d:d --force
bin/console d:d:c
bin/console d:s:u --force
mkdir public/uploads
#yes | bin/console d:f:l