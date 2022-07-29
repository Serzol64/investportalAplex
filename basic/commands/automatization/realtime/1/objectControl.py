import sys
import re
import json
import xlrd

from PSAAutomatizator.accessControl import decryptUserID
from PSAAutomatizator.serviceQueues import QueresDB
from PSAAutomatizator.serviceOperators import Realtime

def getCurrentSubscribes(q):
	
	subscribeResponse = []
	
    if q == 'Private': dColumn = 'Private'
    else: dColumn = 'All'
    
    
    senderQWB = xlrd.open_workbook('../../commands/data/runtimes/Subscribes.xlsx')
    currentSheet = senderQWB.sheet_by_name(dColumn)

     for i in range(currentSheet.nrows):
        if dColumn == 'All':
            if currentSheet.cell_value(i, 0) == 1: subscribeResponse.append(decryptUserID(currentSheet.cell_value(i, 1)))
        else:
			if currentSheet.cell_value(i, 0) == 1: subscribeResponse.append(currentSheet.cell_value(i, 1))
	return subscribeResponse

def realtimeProccess(q):
    subscriptionsList = QueresDB(q.service, q.user, q.data, 'realtime')
    currentSubscription = Realtime(q.user, q.service, q.data)

    if subscriptionsList.start() and currentSubscription.proccess():
		
    else:

if __name__ == "__main__":
	
	if "--fastMode" in sys.args[0]: subscribeData = getCurrentSubscribes('Private')
	else: subscribeData = getCurrentSubscribes('All')
	
	for i in range(len(subscribeData)):
		
		if re.search('', subscribeData[i]):
			visitorQuery = json.loads(subscribeData[i])
			
			responseQueryVisitor = {}
			realtimeProccess(responseQueryVisitor)
		else:
			userQuery = subscribeData[i]
			
			responseQuery = {}
			realtimeProccess(responseQuery)
		
