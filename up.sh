#!/bin/bash

SHOW_LOGS=$1
if [ -z "$SHOW_LOGS" ]
then
  echo "No logs will be shown, to show logs please type: ./up.sh logs"
  echo "-----------------------------------------------------------------"
  echo "Starting up the container docker box..."
  echo "----------------------------------------------------------------- docker-compose up -d --build site "
  docker-compose up -d --build site
  echo "done"
else
  echo "Showing logs"
  echo "-----------------------------------------------------------------"
  echo "Starting up the container"
  echo "-----------------------------------------------------------------"
  docker-compose up --build site
fi
