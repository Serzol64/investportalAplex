import sys
import json
from PSAAutomatizator.accessControl import decryptUserID
from PSAAutomatizator.serviceQueues import QueresDB
from PSAAutomatizator.serviceOperators import Push

import mysql.connector, socket

def getCurrentQueue(q):

    currentQueue = QueresDB(q.service, q.user, q.data, 'send')
    return currentQueue.start()

def addingObjectProccess(q):
    
    findQuery = {}
    currentOperation = Push(q.user, q.service, q.data)
    
    if getCurrentQueue(findQuery):
		currentOperation.start()
		
		dbConnect = ['database', 'developer', '19052000', 'aplex']
		getIp = socket.gethostbyname(socket.gethostname())

		if getIp != '127.0.0.1': dbConnect = [
			'localhost',
			'zolotaryow_inv',
			'pNtJCRTGEZ',
			'zolotaryow_inv']

		cnlx = mysql.connector.connect(
			host=dbConnect[0],
			database=dbConnect[3],
			user=dbConnect[1],
			password=dbConnect[2]
		).cursor()
		
		if not q.userData.visitor: 
			creatorQuery = q.user.userData
		else: 
			creatorQuery = json.dumps(q.user.userData.visitor)
			
		cnlx.execute('SELECT id FROM objectData ORDER BY id DESC LIMIT 1')
		
		for(objectId) in cnlx: 
			if objectId > 1: newId = objectId + 1
			else: newId = 1
		
		galleryQuery = {}
		parameterQuery = {}
		
		if q.queryData.user:
			
			if q.queryData.user[3].photogallery:
				
			if q.queryData.user[3].presentation:
				
		else:
			
			if q.queryData.visitor[3].photogallery:
				
			if q.queryData.visitor[3].presentation:
				
		
		
		
		
		title = q.userData.visitor if q.queryData.visitor[].title else q.queryData.user[].title
		cat = q.userData.visitor if q.queryData.visitor[].category else q.queryData.user[].category
		
		contentQuery = {
			'meta': {
				'description': '',
				'region': {
					'country': '',
					'region': ''
				},
				'mediagallery': galleryQuery,
			},
			'content': {
				'parameters': parameterQuery
			}
		}
		dynamicQuery = {
			'i': 'id',
			'c': 'category',
			't': 'title',
			'cnt': 'content',
			'creator': q.user.userData.visitor if 'visitor' else 'creator',
			'id': newId,
			'cd': title,
			'td': cat,
			'cntd': contentQuery,
			'creatorD': creatorQuery
		}
		
		dataCommit = cnlx.execute(('INSERT INTO objectData (%i, %c, %t, %cnt, %creator) VALUES (%id, %cd, %td, %cntd, %creatorD)'), dynamicQuery).commit()
		
		if dataCommit: 
			responseQuery = q
			successResponse = successProccess(responseQuery)
			
			if successResponse.state == 0: return json.dumps(successResponse.message)
			else: return json.dumps(successResponse.message)
		else: return 'Operation failed'
		
	else: return 'Operation not found'
    
def successProccess(q):
	
	finalResponse = {}
    currentOperation = Push(q.user, q.service, q.data)
    
    if currentOperation.finish():
		finalResponse = {
			'state': 0,
			'message': 'The object has been successfully added to the portal!'
		}
    else:
		finalResponse = {
			'state': 1,
			'message': 'The registration of this object failed'
		}
		
	return finalResponse

if __name__ == "__main__": 
	
		
	if "--userQuery" in sys.argv[0]:
		pushCMD = {}
		readyQuery = json.loads(sys.args[0].strip("--userQuery="))
		
		if registerQueue(readyQuery):
			if "--fastMode" in sys.argv[1]:
				pushCMD = {
					'user' : {
						'userData' : readyQuery.parameters.portalId
					},
					'service': {
						'serviceData' : {
							'id': 1
						}
					},
					'data': {
						'queryData': { 
							'user': [ readyQuery.parameters.text, readyQuery.parameters.search, readyQuery.parameters.list, readyQuery.parameters.upload ]
						}
					}
				}
			else:
				pushCMD = {
					'user' : {
						'userData' : {
							'visitor' : readyQuery.parameters.visitor
						}
					},
					'service': {
						'serviceData' : {
							'id': 1
						}
					},
					'data': {
						'queryData': { 
							'visitor': [ readyQuery.parameters.text, readyQuery.parameters.search, readyQuery.parameters.list, readyQuery.parameters.upload ]
						}
					}
				}
				
				
			print(addingObjectProccess(pushCMD))
		else: 
			print('Queue registration failed!')
	else:
		print('Query not found!')
