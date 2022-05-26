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

class Authorizing():
    def __init__(login):
        self.userLogin = login
    def __control():

    def _verifycation():

    def start():
        return proccessResponse
class Visitor():
    def __init__(visitor):
        self.visitorData = visitor
    def __control():

    def _verifycation():

    def start():
        return proccessResponse