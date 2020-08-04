#!/bin/bash
echo "shouting down the docker compose file..."
docker-compose down -v --rmi local
echo "done."
