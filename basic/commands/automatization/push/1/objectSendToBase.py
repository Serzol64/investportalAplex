import sys
import json
from PSAAutomatizator.accessControl import decryptUserID
from PSAAutomatizator.serviceQueues import QueresDB
from PSAAutomatizator.serviceOperators import Push

import mysql.connector, socket

def getCurrentQueue(q):

    currentQueue = QueresDB(q.service, q.user, q.data, 'push')
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
		
		dataCommit = cnlx.execute().commit()
		
		if dataCommit: 
			responseQuery = {}
			successResponse = successProccess(responseQuery)
			
			if successResponse.state == 0: return json.dumps(successResponse.message)
			else: return successResponse.message
		else: return 'Operation failed'
		
	else:
		return 'Operation not found'
    
def successProccess(q):

    currentOperation = Push(q.user, q.service, q.data)
    
    if currentOperation.finish():
		
    else:
		
if __name__ == "__main__": 
	
		
	if "--userQuery" in sys.argv[0]:
		readyQuery = sys.args[0].strip("--userQuery=")
		
		if registerQueue(readyQuery):
			
			if "--fastMode" in sys.argv[1]:
				
			else:
				
		else:
