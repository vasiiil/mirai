#!/usr/bin/env bash
if [ ! -f ".env" ]
then
    cp .env-dist .env > /dev/null
fi
docker-compose up -d $1 $2