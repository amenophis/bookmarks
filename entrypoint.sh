#!/bin/sh

composer install

exec bin/console server:run 0.0.0.0:8000
