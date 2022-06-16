import mysql.connector
import socket

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

def formGenerator(q):
    

def formValid(q):
    queryPattern = [
        q.fieldFormName.find('objectMedia'),
        q.fieldFormName.find('objectMeta')
    ]


    if queryPattern[1]:
        findMeta = {}
        cnlx.execute('', findMeta)

        for () in cnlx:

        cnlx.close()
    elif queryPattern[0]:
        findMedia = {}
        cnlx.execute('', findMedia)
        for () in cnlx:

        cnlx.close()
    else:
        findOther = {}
        cnlx.execute('', findOther)
        for () in cnlx:

        cnlx.close()


