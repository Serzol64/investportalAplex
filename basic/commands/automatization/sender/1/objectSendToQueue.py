import sys
import json
from PSAAutomatizator.serviceQueues import QueresDB
from PSAAutomatizator.serviceOperators import Send

def registerQueue(q):
    currentQueue = QueresDB(q.service, q.user, q.data, 'send')
    currentProccess = Send(q.user, q.service, q.data)

    if currentQueue.send():
        return currentProccess.start()
    else:
        return False
    
if __name__ == "__main__":
	
	if "--userQuery" in sys.argv[0]:
		responseQuery = {}
		readyQuery = sys.args[0].strip("--userQuery=")
		
		if "--fastMode" in sys.argv[1]: responseQuery = {}
		else: responseQuery = {}
		
		if registerQueue(responseQuery): queueMessage = 'Queue success'
		else: queueMessage = 'Queue failed'
		
		return queueMessage
	else: return 'Queue error'
			
		
