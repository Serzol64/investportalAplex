import mysql.connector
import socket

dbConnect = ['database', 'developer', '19052000', 'aplex']
getIp = socket.gethostbyname(socket.gethostname())

if getIp != '127.0.0.1': dbConnect = ['localhost', 'zolotaryow_inv', 'pNtJCRTGEZ', 'zolotaryow_inv']

cnlx = mysql.connector.connect(
    host=dbConnect[0],
    database=dbConnect[3],
    user=dbConnect[1],
    password=dbConnect[2]
).cursor()

class ServiceOperator():
    def __init__(user, svc, q):
        self.userData = user
        self.serviceData = svc
        self.queryData = q
    def start():
        return proccessResponse
    def proccess():

    def finish():

    def ready():


class Sender(ServiceOperator):
    def proccess():
        SUpdateQuery = ('')
    def ready():
        

class Push(ServiceOperator):
    def start():
        PUpdateQuery = ('')
    def proccess():
        PUpdateQuery = ('')
    def finish():
        PUpdateQuery = ('')
    def ready():


class Realtime(ServiceOperator):
    def start():
        RUpdateQuery = ('')
    def proccess():
        RUpdateQuery = ('')
    def finish():
        RUpdateQuery = ('')
    def ready():

