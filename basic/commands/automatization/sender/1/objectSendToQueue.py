from PSAAutomatizator.serviceQueues import QueresDB
from PSAAutomatizator.serviceOperators import Send

def registerQueue(q):
    currentQueue = QueresDB(q.service, q.user, q.data, 'send')
    currentProccess = Send(q.user, q.service, q.data)

    if currentQueue.send():
        return currentProccess.start()
    else:
        return False
    