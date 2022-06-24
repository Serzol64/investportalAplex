from PSAAutomatizator.accessControl import decryptUserID
from PSAAutomatizator.serviceQueues import QueresDB
from PSAAutomatizator.serviceOperators import Push

def getCurrentQueue(q):

    currentQueue = QueresDB(q.service, q.user, q.data, 'push')

def addingObjectProccess(q):
    
    currentOperation = Push(q.user, q.service, q.data)

def successProccess(q):

    currentOperation = Push(q.user, q.service, q.data)