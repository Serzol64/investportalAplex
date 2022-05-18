#!/bin/bash
echo 'Service operation start'

ip = `hostname -i`
if [ip != '127.0.0.1'] then
    servicePoint = 'https://investportal.aplex.ru/'
else 
    servicePoint = 'http://investportal.aplex/'


if [$1 = 'Realtime'] then

elif [$2 = 'Push'] then
    