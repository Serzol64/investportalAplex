import sys
import xlrd

from PSAAutomatizator.accessControl import decryptUserID
from PSAAutomatizator.serviceQueues import QueresDB
from PSAAutomatizator.serviceOperators import Realtime

def getCurrentSubscribes():
    for param in sys.argv:
        if param == '': dColumn = 'Private'
        else: dColumn = 'All'
    
    senderQWB = xlrd.open_workbook('../../commands/data/senders/Queues.xlsx')
    currentSheet = senderQWB.sheet_by_name(dColumn)

     for i in range(currentSheet.nrows):
        if dColumn == 'All':
            
        else:
			


def realtimeProccess(q):
    subscriptionsList = QueresDB(q.service, q.user, q.data, 'realtime')
    currentSubscription = Realtime(q.user, q.service, q.data)

    if subscriptionsList.start() and currentSubscription.proccess():

    else:

if __name__ == "__main__":
	
	if "--userQuery" in sys.argv[0]:
		readyQuery = sys.args[0].strip("--userQuery=")
		
		if registerQueue(readyQuery):
			
			if "--fastMode" in sys.argv[1]:
				
			else:
				
		else:
