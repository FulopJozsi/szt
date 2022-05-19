#!/bin/bash

cd /application/docker/cert \
&& openssl req -x509 -sha256 -nodes -days 365 -newkey rsa:2048 -keyout szallas_dev_hu.key -out szallas_dev_hu.crt -subj "/C=HU/ST=Budapest/L=Gyongyos/O=Fulop/OU=Dev/CN=*.szallas.dev.hu"
