import sys
import json
from PSAAutomatizator.accessControl import decryptUserID
from PSAAutomatizator.serviceQueues import QueresDB
from PSAAutomatizator.serviceOperators import Push

def getCurrentQueue(q):

    currentQueue = QueresDB(q.service, q.user, q.data, 'push')
    return currentQueue.start()

def addingObjectProccess(q):
    
    currentOperation = Push(q.user, q.service, q.data)
    
    
def successProccess(q):

    currentOperation = Push(q.user, q.service, q.data)
    
if __name__ == "__main__": 
	
		
	if "--userQuery" in sys.argv[0]:
		readyQuery = sys.args[0].strip("--userQuery=")
		
		if registerQueue(readyQuery):
			
			if "--fastMode" in sys.argv[1]:
				
			else:
				
		else:
