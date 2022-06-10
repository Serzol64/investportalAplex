import mysql.connector
import socket

from serviceMonitor import SMS, Messenger, EMail

dbConnect = ['database', 'developer', '19052000', 'aplex']
getIp = socket.gethostbyname(socket.gethostname())

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


class Sender():
        def __init__(self, user, svc, q):
                self.userData = user
                self.serviceData = svc
                self.queryData = q
        def start(self):

                if self.userData.visitor:
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
                else:
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
                        
                cnlx.execute(('INSERT INTO serviceRunners (%ut, %id, %st, %l) VALUES (%uq, %sq, %stq, $lq)'), dynamicQuery)
                
                if cnlx.commit(): 
                        return 'sOK'
                else: 
                        return 'sFAIL'
                cnlx.close()
        def finish(self):
        
                if self.userData.visitor:
                        dynamicQuery = {
                                'uc': 'visitorData',
                                'uq': self.userData.visitor,
                                'sq': self.serviceData.id,
                                'stq': 0,
                                'lq': 3
                        }
                else:
                        dynamicQuery = {
                                'uc': 'userId',
                                'uq': self.userData,
                                'sq': self.serviceData.id,
                                'stq': 0,
                                'lq': 3
                        }
                        
                commit = cnlx.execute(('UPDATE serviceRunners SET level=%lq WHERE status=%stq AND id=%sq AND %uc=%uq'), dynamicQuery)
                
                if commit: return 'sOK'
                else: return 'sFAIL'
        
                cnlx.close()

class Push():
        def __init__(self, user, svc, q):
                self.userData = user
                self.serviceData = svc
                self.queryData = q
        def start(self):

                if self.userData.visitor:
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
                else:
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
                        
                cnlx.execute(('INSERT INTO serviceRunners (%ut, %id, %st, %l) VALUES (%uq, %sq, %stq, $lq)'), dynamicQuery)
                
                if cnlx.commit(): return 'pOK'
                else: return 'pFAIL'
        
        
                cnlx.close()
     
        def proccess(self):
        
                if self.userData.visitor:
                        dynamicQuery = {
                                'uc': 'visitorData',
                                'uq': self.userData.visitor,
                                'sq': self.serviceData.id,
                                'stq': 1,
                                'lq': 2
                        }
                else:
                        dynamicQuery = {
                                'uc': 'userId',
                                'uq': self.userData,
                                'sq': self.serviceData.id,
                                'stq': 1,
                                'lq': 2
                        }
                        
                commit = cnlx.execute(('UPDATE serviceRunners SET level=%lq WHERE status=%stq AND id=%sq AND %uc=%uq'), dynamicQuery)
                
                if commit: return 'pOK'
                else: return 'pFAIL'
        
                cnlx.close()
    
        def finish(self):
        
                if self.userData.visitor:
                        dynamicQuery = {
                                'uc': 'visitorData',
                                'uq': self.userData.visitor,
                                'sq': self.serviceData.id,
                                'stq': 1,
                                'lq': 3
                        }
                else:
                        dynamicQuery = {
                                'uc': 'userId',
                                'uq': self.userData,
                                'sq': self.serviceData.id,
                                'stq': 1,
                                'lq': 3
                        }
                        
                commit = cnlx.execute(('UPDATE serviceRunners SET level=%lq WHERE status=%stq AND id=%sq AND %uc=%uq'), dynamicQuery)
                
                if commit: 
                        s = dynamicQuery.uq
                        svc = {
                                'mode': 'push',
                                'meta': [
                                        { 'title': self.serviceData.title }
                                ]
                        }
                        q = {
                                'state': 'success',
                                'meta': [
                                        { 'accessLevel': self.userData.visitor if False else True }
                                ]
                        }
                        
                        SMS(s, svc, q).send()
                        Messenger(s, svc, q).send()
                        EMail(s, svc, q).send()
                        
                        return 'pOK'
                else: return 'pFAIL'
                
                cnlx.close()
class Realtime():
        def __init__(self, user, svc, q):
                self.userData = user
                self.serviceData = svc
                self.queryData = q
        def start(self):
                if self.userData.visitor:
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
                else:
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
                        
                cnlx.execute(('INSERT INTO serviceRunners (%ut, %id, %st, %l) VALUES (%uq, %sq, %stq, $lq)'), dynamicQuery)
                
                if cnlx.commit(): 
                        s = dynamicQuery.uq
                        svc = {
                                'mode': 'realtime',
                                'meta': [
                                        { 'title': self.serviceData.title }
                                ]
                        }
                        q = {
                                'state': 'started',
                                'meta': [
                                       { 'accessLevel': self.userData.visitor if False else True }
                                ]
                        }
                        
                        Messenger(s, svc, q).send()
                        
                        return 'rOK'
                else: return 'rFAIL'
                cnlx.close()
    
        def proccess(self):
                if self.userData.visitor:
                        dynamicQuery = {
                                'uc': 'visitorData',
                                'uq': self.userData.visitor,
                                'sq': self.serviceData.id,
                                'stq': 2,
                                'lq': 2
                        }
                else:
                        dynamicQuery = {
                                'uc': 'userId',
                                'uq': self.userData,
                                'sq': self.serviceData.id,
                                'stq': 2,
                                'lq': 2
                        }
                commit = cnlx.execute(('UPDATE serviceRunners SET level=%lq WHERE status=%stq AND id=%sq AND %uc=%uq'), dynamicQuery)
                
                if commit: 
                        s = dynamicQuery.uq
                        svc = {
                                'mode': 'realtime',
                                'meta': [
                                        { 'title': self.serviceData.title }
                                ]
                        }
                        q = {
                                'state': 'running',
                                'meta': [
                                        { 'accessLevel': self.userData.visitor if False else True }
                                ]
                        }
                        
                        Messenger(s, svc, q).send()
                        
                        return 'rOK'
                else: return 'rFAIL'

                cnlx.close()  
    
        def finish(self):
    
                if self.userData.visitor:
                        dynamicQuery = {
                                'uc': 'visitorData',
                                'uq': self.userData.visitor,
                                'sq': self.serviceData.id,
                                'stq': 2,
                                'lq': 3
                        }
                else:
                        dynamicQuery = {
                                'uc': 'userId',
                                'uq': self.userData,
                                'sq': self.serviceData.id,
                                'stq': 2,
                                'lq': 3
                        }
                        
                commit = cnlx.execute(('UPDATE serviceRunners SET level=%lq WHERE status=%stq AND id=%sq AND %uc=%uq'), dynamicQuery)
                
                if commit: 
                        s = dynamicQuery.uq
                        svc = {
                                'mode': 'realtime',
                                'meta': [
                                        { 'title': self.serviceData.title }
                                ]
                        }
                        q = {
                                'state': 'success',
                                'meta': [
                                        { 'accessLevel': self.userData.visitor if False else True }
                                ]
                        }
                        
                        SMS(s, svc, q).send()
                        Messenger(s, svc, q).send()
                        EMail(s, svc, q).send()
                        return 'rOK'
                else: return 'rFAIL'
                cnlx.close()
