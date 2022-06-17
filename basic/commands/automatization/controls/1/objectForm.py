from asyncio.windows_events import NULL
import mysql.connector
from decimal import Decimal
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

        for (field, type) in cnlx:
            if q.fieldFormName.find(field):
                if type == 'country' or type == 'region':

                elif type == 'cost':
                    if Decimal(q.fieldFormQuery) % 1 == 0: validMetaMessage = 'Success'
                    else: validMetaMessage = 'The entered data should correspond to this format: 1000000,00'
                elif type == 'precentable':
                    if len(q.fieldFormQuery) < 3 or len(q.fieldFormQuery) == 3: validMetaMessage = 'Success'
                    else: validMetaMessage = 'The maximum number of characters in a number is 3'
                elif type == 'int':
                    if len(q.fieldFormQuery) < 6 or len(q.fieldFormQuery) == 6: validMetaMessage = 'Success'
                    else: validMetaMessage = 'The maximum number of characters in a number is 6'
            
        cnlx.close()
        validResponse = {'message': validMetaMessage}
    elif queryPattern[0]:
        findMedia = {}
        cnlx.execute('', findMedia)
        for (field, type) in cnlx:
            if q.fieldFormName.find(field):
                if type == 'photogallery':
                    
        cnlx.close()
    else:
        findOther = {}
        cnlx.execute('', findOther)
        for (field, type) in cnlx:
            if q.fieldFormName.find(field):
                if type == 'default':

                elif type == 'selecting':
                    
        cnlx.close()
    return validResponse

