#!/bin/bash
print('Service operation start');

ip = `hostname -i`
if [ip != '127.0.0.1'] then
    servicePoint = 'curl -sS https://investportal.aplex.ru/';
else 
    servicePoint = 'curl http://investportal.aplex/';


if [$1 = 'Realtime'] then
    realtimeServiceQuery = servicePoint + `admin/api/dataServices/filters/portalServices/show` | jq -r '[].id, [].meta'
    realtimeServiceQuery | while read i; do
        if [i.accessRole = 'public'] then
            serviceRun = `php ../../yii portal-service-realtime -serviceId=${i.id} -userAuthType=false`
            print(serviceRun)
    done;
elif [$1 = 'Push'] then
    pushServiceQuery = servicePoint + `admin/api/dataServices/filters/portalServices/show` | jq -r '[].id, [].meta'
    realtimeServiceQuery | while read i; do
        if [i.accessRole = 'public'] then
            serviceRun = `php ../../yii portal-service-push -serviceId=${i.id} -userAuthType=false`
            print(serviceRun)
    done;
elif [$1 = 'contentCategorizator'] then
	smartRun = (`php ../../yii portal-content-categorizator/news` `php ../../yii portal-content-categorizator/analytics` `php ../../yii portal-content-categorizator/events`)
	
	for i in ${smartRun[@]}
	do
		print(i)
	done;
	
print('Service operation finish');
