#!/usr/bin/env bash
apk --no-cache add postgresql-dev
docker-php-ext-configure pgsql
docker-php-ext-install pdo pdo_pgsql pgsql
