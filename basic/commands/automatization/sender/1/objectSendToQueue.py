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
		readyQuery = sys.args[0].strip("--userQuery=")
		
		if registerQueue(readyQuery):
			
			if "--fastMode" in sys.argv[1]:
				
			else:
				
		else:
			
		
