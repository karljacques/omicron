#!/usr/bin/env bash
docker-php-ext-configure pgsql
docker-php-ext-install pdo pdo_pgsql pgsql
