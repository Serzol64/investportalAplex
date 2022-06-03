import mysql.connector
import socket

from serviceMonitor import SMS, Messenger, EMail

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
    def proccess():
    def finish():

class Sender(ServiceOperator):
	def start():
		dynamicQuery = {}
        SUpdateQuery = ('INSERT INTO serviceRunners (%ut, %id, %st, %l) VALUES (%uq, %sq, %stq, $lq)')
        
        if !self.userData.visitor:
			dynamicQuery = {
				'ut': 'userId',
				'id': 'serviceId',
				'st': 'status',
				'l': 'level',
				'uq': self.userData,
				'sq': self.serviceData.id,
				'stq': 0,
				'lq': 1
			}
		else:
			dynamicQuery = {
				'ut': 'visitorData',
				'id': 'serviceId',
				'st': 'status',
				'l': 'level',
				'uq': self.userData.visitor,
				'sq': self.serviceData.id,
				'stq': 0,
				'lq': 1
			}
			
		cnlx.execute(SUpdateQuery, dynamicQuery)
		
		if cnlx.commit(): return 'sOK'
		else: return 'sFAIL'
        
        cnlx.close()
        
    def finish():
		dynamicQuery = {}
        SUpdateQuery = ('UPDATE serviceRunners SET level=%lq WHERE status=%stq AND id=%sq AND %uc=%uq')
        
        if !self.userData.visitor:
			dynamicQuery = {
				'uc': 'userId',
				'uq': self.userData,
				'sq': self.serviceData.id,
				'stq': 0,
				'lq': 3
			}
		else:
			dynamicQuery = {
				'uc': 'visitorData',
				'uq': self.userData.visitor,
				'sq': self.serviceData.id,
				'stq': 0,
				'lq': 3
			}
			
		commit = cnlx.execute(SUpdateQuery, dynamicQuery)
		
		if commit: return 'sOK'
		else: return 'sFAIL'
        
        cnlx.close()

class Push(ServiceOperator):
    def start():
        dynamicQuery = {}
        PUpdateQuery = ('INSERT INTO serviceRunners (%ut, %id, %st, %l) VALUES (%uq, %sq, %stq, $lq)')
        
        if !self.userData.visitor:
			dynamicQuery = {
				'ut': 'userId',
				'id': 'serviceId',
				'st': 'status',
				'l': 'level',
				'uq': self.userData,
				'sq': self.serviceData.id,
				'stq': 1,
				'lq': 1
			}
		else:
			dynamicQuery = {
				'ut': 'visitorData',
				'id': 'serviceId',
				'st': 'status',
				'l': 'level',
				'uq': self.userData.visitor,
				'sq': self.serviceData.id,
				'stq': 1,
				'lq': 1
			}
			
		cnlx.execute(PUpdateQuery, dynamicQuery)
		
		if cnlx.commit(): return 'pOK'
		else: return 'pFAIL'
        
        
        cnlx.close()
    def proccess():
		dynamicQuery = {}
        PUpdateQuery = ('UPDATE serviceRunners SET level=%lq WHERE status=%stq AND id=%sq AND %uc=%uq')
        
        if !self.userData.visitor:
			dynamicQuery = {
				'uc': 'userId',
				'uq': self.userData,
				'sq': self.serviceData.id,
				'stq': 1,
				'lq': 2
			}
		else:
			dynamicQuery = {
				'uc': 'visitorData',
				'uq': self.userData.visitor,
				'sq': self.serviceData.id,
				'stq': 1,
				'lq': 2
			}
			
		commit = cnlx.execute(PUpdateQuery, dynamicQuery)
		
		if commit: return 'pOK'
		else: return 'pFAIL'
        
        cnlx.close()
    def finish():
		dynamicQuery = {}
        PUpdateQuery = ('UPDATE serviceRunners SET level=%lq WHERE status=%stq AND id=%sq AND %uc=%uq')
        
        if !self.userData.visitor:
			dynamicQuery = {
				'uc': 'userId',
				'uq': self.userData,
				'sq': self.serviceData.id,
				'stq': 1,
				'lq': 3
			}
		else:
			dynamicQuery = {
				'uc': 'visitorData',
				'uq': self.userData.visitor,
				'sq': self.serviceData.id,
				'stq': 1,
				'lq': 3
			}
			
		commit = cnlx.execute(PUpdateQuery, dynamicQuery)
		
		if commit: return 'pOK'
		else: return 'pFAIL'
		
        cnlx.close()

class Realtime(ServiceOperator):
    def start():
        dynamicQuery = {}
        RUpdateQuery = ('INSERT INTO serviceRunners (%ut, %id, %st, %l) VALUES (%uq, %sq, %stq, $lq)')
        
        if !self.userData.visitor:
			dynamicQuery = {
				'ut': 'userId',
				'id': 'serviceId',
				'st': 'status',
				'l': 'level',
				'uq': self.userData,
				'sq': self.serviceData.id,
				'stq': 2,
				'lq': 1
			}
		else:
			dynamicQuery = {
				'ut': 'visitorData',
				'id': 'serviceId',
				'st': 'status',
				'l': 'level',
				'uq': self.userData.visitor,
				'sq': self.serviceData.id,
				'stq': 2,
				'lq': 1
			}
			
		cnlx.execute(RUpdateQuery, dynamicQuery)
		
		if cnlx.commit(): return 'rOK'
		else: return 'rFAIL'
        
        
        cnlx.close()
    def proccess():
		dynamicQuery = {}
        RUpdateQuery = ('UPDATE serviceRunners SET level=%lq WHERE status=%stq AND id=%sq AND %uc=%uq')
        
        
        if !self.userData.visitor:
			dynamicQuery = {
				'uc': 'userId',
				'uq': self.userData,
				'sq': self.serviceData.id,
				'stq': 2,
				'lq': 2
			}
		else:
			dynamicQuery = {
				'uc': 'visitorData',
				'uq': self.userData.visitor,
				'sq': self.serviceData.id,
				'stq': 2,
				'lq': 2
			}
			
		commit = cnlx.execute(RUpdateQuery, dynamicQuery)
		
		if commit: return 'rOK'
		else: return 'rFAIL'
		
        cnlx.close()
        
    def finish():
        dynamicQuery = {}
        RUpdateQuery = ('UPDATE serviceRunners SET level=%lq WHERE status=%stq AND id=%sq AND %uc=%uq')
        
        
        if !self.userData.visitor:
			dynamicQuery = {
				'uc': 'userId',
				'uq': self.userData,
				'sq': self.serviceData.id,
				'stq': 2,
				'lq': 3
			}
		else:
			dynamicQuery = {
				'uc': 'visitorData',
				'uq': self.userData.visitor,
				'sq': self.serviceData.id,
				'stq': 2,
				'lq': 3
			}
			
		commit = cnlx.execute(RUpdateQuery, dynamicQuery)
		
		if commit: return 'rOK'
		else: return 'rFAIL'
		
        cnlx.close()
