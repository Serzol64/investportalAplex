import time
import hashlib
import userID_decryptor
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

def generateCryptoUser(login):
	currentTime = time.time()
	currentUser = login
	
	contactQuery = ('SELECT firstname, country, phone FROM users WHERE login=%s')
	contactQ = cnlx.execute(contactQuery, (contactQuery))
	
	for (firstname, country, phone) in cnlx:
		currentName = firstname
		currentRegion = country
		currentPhone = phone
		
	idResponse = hashlib.md5(currentUser + '/' + currentTime + '/' + currentPhone + '/' + currentRegion + '/' + currentName).hexdigest()
	return idResponse
	
def decryptUserID(hashQuery):
	decryptResponse = decryptMD5(hashQuery)
	getResponse = decryptResponse.split('/')
	
	return { 'login': getResponse[0], 'phone': getResponse[2], 'region': getResponse[3] }
	
	
