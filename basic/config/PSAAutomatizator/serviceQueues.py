import datetime
import pandas
import xlrd
import openpyxl

class QueresDB():
    def __init__(svc,user,q,t):
        self.serviceData = svc
        self.userData = user
        self.queryData = q
        self.typeData = t
    def start():
        if self.typeData.type == 'send':
			if self.queryData.cmd == 'register':
				if !self.userData.visitor: dColumn = 'Private'
				else: dColumn = 'All'
				
				newQuery = {}
				senderQueues = pandas.read_excel('../../commands/data/senders/Queues.xlsx', sheet_name=dColumn)
				
				if dColumn != 'All': newQuery = {'ServiceID': self.serviceData.id, 'SenderID': self.userData, 'Datetime': datetime.datetime.now(), 'clientQuery': self.queryData.user}
				else: newQuery = {'ServiceID': self.serviceData.id, 'Datetime': datetime.datetime.now(), 'visitorQuery': self.userData.visitor, 'clientQuery': self.queryData.visitor}
				
				senderQueues.append(newQuery)
				
				registerSuccess = senderQueues.to_excel('../../commands/data/senders/Queues.xlsx', sheet_name=dColumn)
				
				if registerSuccess: proccessResponse = 'qrOK'
				else: proccessResponse = 'qrFailed'
					
			elif self.queryData.cmd == 'update':
				if !self.userData.visitor: dColumn = 'Private'
				else: dColumn = 'All'
				
				updateQuery = ''
				senderQueues = pandas.read_excel('../../commands/data/senders/Queues.xlsx', sheet_name=dColumn)
				
				if dColumn != 'All': updateQuery = self.userData.new
				else: updateQuery = self.userData.new.visitor
				
				senderQueues.replace(self.userData.old, updateQuery)
				updateSuccess = senderQueues.to_excel('../../commands/data/senders/Queues.xlsx', sheet_name=dColumn)
				
				if updateSuccess: proccessResponse = 'quOK'
				else: proccessResponse = 'quFailed'
				
			elif self.queryData.cmd == 'find':
				searchResponse = []
				
				if !self.userData.visitor: dColumn = 'Private'
				else: dColumn = 'All'
				
				senderQWB = xlrd.open_workbook('../../commands/data/senders/Queues.xlsx')
				currentSheet = senderQWB.sheet_by_name(dColumn)
				
				for i in range(currentSheet.nrows):
					findDataParameter = dColumn != 'All' ?
										(self.serviceData.id == currentSheet.cell_value(i, 0) and self.userData == currentSheet.cell_value(i, 1)) :
										(self.serviceData.id == currentSheet.cell_value(i, 0) and self.userData.visitor == currentSheet.cell_value(i, 2))
										
					if findDataParameter:
						searchResponse.append(dColumn != 'All' ?
										 {
											'svc': currentSheet.cell_value(i, 0),
											'datetime': currentSheet.cell_value(i, 2),
											'query': currentSheet.cell_value(i, 3)
										 } :
										 {
											'svc': currentSheet.cell_value(i, 0),
											'datetime': currentSheet.cell_value(i, 1),
											'query': currentSheet.cell_value(i, 3)
										 })
					
				proccessResponse = searchResponse
				
			elif self.queryData.cmd == 'delete':
				if !self.userData.visitor: dColumn = 'Private'
				else: dColumn = 'All'
				
				senderQueues = pandas.read_excel('../../commands/data/senders/Queues.xlsx', sheet_name=dColumn)
				
				findIndexFrame = senderQueues.set_index(['ServiceID', 'Datetime', 'clientQuery'])
				deleteCurrentQueue = findIndexFrame.drop([self.serviceData.id, self.queryData.datetime, self.queryData.query], axis=[0,1,2])
				
				deleteSuccess = deleteCurrentQueue.to_excel('../../commands/data/senders/Queues.xlsx', sheet_name=dColumn)
				
				if deleteSuccess: proccessResponse = 'qdOK'
				else: proccessResponse = 'qdFailed'
				
        elif self.typeData.type == 'realtime':
			if self.queryData.cmd == 'register':
				if !self.userData.visitor: dColumn = 'Private'
				else: dColumn = 'All'
				
				newQuery = {}
				subscribeQueues = pandas.read_excel('../../commands/data/runtimes/Subscribes.xlsx', sheet_name=dColumn)
				
				if dColumn != 'All': newQuery = {'ServiceID': self.serviceData.id, 'UserID': self.userData}
				else: newQuery = {'ServiceID': self.serviceData.id, 'visitorData': self.userData.visitor}
				
				subscribeQueues.append(newQuery)
				
				registerSuccess = subscribeQueues.to_excel('../../commands/data/runtimes/Subscribes.xlsx', sheet_name=dColumn)
				
				if registerSuccess: proccessResponse = 'qrOK'
				else: proccessResponse = 'qrFailed'
				
			elif self.queryData.cmd == 'update':
				if !self.userData.visitor: dColumn = 'Private'
				else: dColumn = 'All'
				
				updateQuery = ''
				subscribeQueues = pandas.read_excel('../../commands/data/runtimes/Subscribes.xlsx', sheet_name=dColumn)
				
				if dColumn != 'All': updateQuery = self.userData.new
				else: updateQuery = self.userData.new.visitor
				
				subscribeQueues.replace(self.userData.old, updateQuery)
				updateSuccess = subscribeQueues.to_excel('../../commands/data/runtimes/Subscribes.xlsx', sheet_name=dColumn)
				
				if updateSuccess: proccessResponse = 'quOK'
				else: proccessResponse = 'quFailed'
				
			elif self.queryData.cmd == 'find':
				searchResponse = []
				
				if !self.userData.visitor: dColumn = 'Private'
				else: dColumn = 'All'
				
				senderQWB = xlrd.open_workbook('../../commands/data/senders/Queues.xlsx')
				currentSheet = senderQWB.sheet_by_name(dColumn)
				
				for i in range(currentSheet.nrows):
					findDataParameter = dColumn != 'All' ?
										(self.userData == currentSheet.cell_value(i, 1)) :
										(self.userData.visitor == currentSheet.cell_value(i, 1))
										
					if findDataParameter: searchResponse.append(currentSheet.cell_value(i, 0))
					
				proccessResponse = searchResponse
				
			elif self.queryData.cmd == 'delete':
				if !self.userData.visitor: dColumn = 'Private'
				else: dColumn = 'All'
				
				subscribeQueues = pandas.read_excel('../../commands/data/runtimes/Subscribes.xlsx', sheet_name=dColumn)
				
				findIndexFrame = subscribeQueues.set_index(['ServiceID', dColumn != 'All' ? 'UserID' : 'visitorQuery'])
				deleteCurrentQueue = findIndexFrame.drop([self.serviceData.id, dColumn != 'All' ? self.userData : self.userData.visitor], axis=[0,1])
				
				deleteSuccess = deleteCurrentQueue.to_excel('../../commands/data/senders/Queues.xlsx', sheet_name=dColumn)
				
				if deleteSuccess: proccessResponse = 'qdOK'
				else: proccessResponse = 'qdFailed'
				
        return proccessResponse
		
