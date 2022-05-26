#!/bin/bash
print('Service operation start');

ip = `hostname -i`
if [ip != '127.0.0.1'] then
    servicePoint = 'curl -sS https://investportal.aplex.ru/';
else 
    servicePoint = 'curl http://investportal.aplex/';


if [$1 = 'Realtime'] then
    realtimeServiceQuery = servicePoint + `admin/api/dataServices/filters/portalServices/show` | jq -r '[].id'
    realtimeServiceQuery | while read i; do
        serviceRun = `php ../../yii portal-service-realtime -serviceId=${i.id} -userAuthType=true`
        print(serviceRun)
    done;
elif [$2 = 'Push'] then
    pushServiceQuery = servicePoint + `admin/api/dataServices/filters/portalServices/show` | jq -r '[].id'
    realtimeServiceQuery | while read i; do
        serviceRun = `php ../../yii portal-service-push -serviceId=${i.id} -userAuthType=true`
        print(serviceRun)
    done;

print('Service operation finish');