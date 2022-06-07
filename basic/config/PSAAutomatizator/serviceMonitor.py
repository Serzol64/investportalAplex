import os
import requests
import pywhatkit
import mysql.connector
import socket

from yattag import Doc

from aiohttp import web

from aioviberbot import Api
from aioviberbot.api.bot_configuration import BotConfiguration
from aioviberbot.api.messages.text_message import TextMessage
from aioviberbot.api.viber_requests import ViberConversationStartedRequest
from aioviberbot.api.viber_requests import ViberMessageRequest
from aioviberbot.api.viber_requests import ViberSubscribedRequest

from smsru_api import SmsRu

import * as serviceMonitor

dbConnect = ['database', 'developer', '19052000', 'aplex']
getIp = socket.gethostbyname(socket.gethostname())

if getIp != '127.0.0.1': dbConnect = ['localhost', 'zolotaryow_inv', 'pNtJCRTGEZ', 'zolotaryow_inv']

cnlx = mysql.connector.connect(
    host=dbConnect[0],
    database=dbConnect[3],
    user=dbConnect[1],
    password=dbConnect[2]
).cursor()

def telegram_bot_sendtext(bot_message):

   bot_token = '5590053001:AAEZMM5vnKzdNmPFy-cTpe-2WLWQdTQmx4c'
   bot_chatID = '1481431715'
   send_text = 'https://api.telegram.org/bot' + bot_token + '/sendMessage?chat_id=' + bot_chatID + '&parse_mode=Markdown&text=' + bot_message

   response = requests.get(send_text)

   return response.json()
   
def isUserPhone(q):
	isFound = false
	getPhones = ('SELECT phone FROM users')
	
	cnlx.execute(getPhones)
	
	for(phone) in cnlx:
		if phone == q:
			isFound = true
			break
		
	cnlx.close()
	
	return isFound

def getSmartMailMessage(typeQ, dataQ):
	
	
async def viber_bot_sendtext(bot_data, bot_config, bot_message) -> web.Response:
	request_data = await bot_config.read()
    signature = bot_config.headers.get('X-Viber-Content-Signature')
    if not bot_data.verify_signature(request_data, signature):
        raise web.HTTPForbidden

    viber_request = bot_data.parse_request(request_data)
	
    if isinstance(viber_request, ViberSubscribedRequest):
		if isUserPhone(viber_request.user.id):
			await viber.send_messages(
				viber_request.user.id,
				[TextMessage(text=bot_message)]
			)
    elif isinstance(viber_request, ViberConversationStartedRequest):
		if isUserPhone(viber_request.user.id):
			await viber.send_messages(
				viber_request.user.id,
				[TextMessage(text=bot_message)]
			)
		else:
			await viber.send_messages(
				viber_request.user.id,
				[TextMessage(text='Some of your personal data could not be found because you are not registered on the portal!')]
			)
    else:
		await viber.send_messages(
            viber_request.sender.id,
            [TextMessage(text=bot_message)]
        )

    return web.json_response({'ok': True})

class PortalUserNotificator():
    def __init__(contacts, service, query):
        self.contactData = contacts
        self.serviceData = service
        self.queryData = query
    def send():
    def _findContact():


class SMS(PortalUserNotificator):
    def send():
        statusInfo = ''
        if self.queryData.state == 'success':
            if self.serviceData.mode == 'push': statusInfo = 'Your query proccessing success'
            elif self.serviceData.mode == 'realtime': statusInfo = 'Your query consideration success'
    
        currentContact = self._findContact()
        messengerMessage = self._messageGenerator([statusInfo, self.queryData.meta, self.serviceData.meta])
        
        proccessResponse = sms_ru.send(currentContact, message=messengerMessage)
        return proccessResponse
    def _textGenerator(message):
        sdr = message[2]
        qdr = message[1]

		serviceDescription = 'in portal service \"' + sdr.title + '\"!'
		
		if qdr.accessLevel: queryDescription = 'This request was processed with secure verified access.'
		else: queryDescription = 'This request was processed with visit verified access.'

        return message[0] + ' ' + serviceDescription + '\n' + queryDescription

    def _findContact():
		

class Messenger(PortalUserNotificator):
    def send():
        statusInfo = ''
        if self.queryData.state == 'success':
            if self.serviceData.mode == 'push': statusInfo = 'Your query proccessing success'
            elif self.serviceData.mode == 'realtime': statusInfo = 'Your query consideration success'
        elif self.queryData.state == 'running' and self.serviceData.mode == 'realtime': statusInfo = 'Runnung your query consideration proccess'
        elif self.queryData.state == 'started' and self.serviceData.mode == 'realtime': statusInfo = 'Starting your query consideration'
        
        currentContact = self._findContact()
        messengerMessage = self._messageGenerator([statusInfo, self.queryData.meta, self.serviceData.meta], currentContact)

        if currentContact.isWhatsApp:
			sendWAMessage = pywhatkit.sendwhatmsg('', messengerMessage, currentTime[0], currentTime[1])
			proccessResponse = sendWAMessage
        elif currentContact.isViber:
			bot_configuration = BotConfiguration(
				auth_token='4f41073ec4e7deb5-a1ecd472b8155552-cf2d366cd7109b40'
			)
			viber = Api(bot_configuration)
			
			vResponse = viber_bot_sendtext(viber, web.Request, messengerMessage)
			sendVMessage = vResponse
			
			proccessResponse = sendVMessage
        elif currentContact.isTG:
			tgResponse = telegram_bot_sendtext(messengerMessage)
			sendTGMessage = tgResponse
			
			proccessResponse = sendTGMessage
		
        return proccessResponse
    def _messageGenerator(message, contact):
        sdr = message[2]
        qdr = message[1]
        
        serviceDescription = 'in portal service *\"' + sdr.title + '\"*!'
		
		if qdr.accessLevel: queryDescription = 'This request was processed with secure verified access.'
		else: queryDescription = 'This request was processed with visit verified access.'
		
		if contact.isTG or contact.isViber: mesRes = '**' + message[0] + ' ' + serviceDescription + '**\n' + queryDescription + ''
		else: mesRes = message[0] + ' ' + serviceDescription + '\n' + queryDescription

        return mesRes
        
    def _findContact():

class EMail(PortalUserNotificator):
    def send():
        statusInfo = ''
        if self.queryData.state == 'success':
            if self.serviceData.mode == 'push': statusInfo = 'Your query proccessing success'
            elif self.serviceData.mode == 'realtime': statusInfo = 'Your query consideration success'
    
        currentContact = self._findContact()
        messengerMessage = self._messageGenerator([statusInfo, self.queryData.meta, self.serviceData.meta])
        
        proccessResponse = pywhatkit.send_mail(os.environ['INVESTPORTAL_MAIL_LOGIN'], os.environ['INVESTPORTAL_MAIL_PWD'], messengerMessage.theme, messengerMessage.startmessage + messengerMessage.svc + messengerMessage.q, currentContact.email)
    
        return proccessResponse    
    def _messageGenerator(message):
		
		doc, tag, text = Doc().tagtext()
		docD, tagD, textD = Doc().tagtext()
		docDD, tagDD, textDD = Doc().tagtext()
		
		stateMessage = message[0]
		serviceResponse = getSmartMailMessage(0, message[2])
		queryResponse = getSmartMailMessage(1, message[1])
		
		doc.asis('<!DOCTYPE html>')
		with tag('html', lang='eu-US')
			with tag('head')
				with tag('title')
					text(stateMessage)
				with tag('meta', charset='UTF-8')
			
		helloMessage = doc.getvalue()
		
		docD.asis('<body><p>')
		with tag('strong')
			text('Dear ' + self.contactData.visitor ? self.contactData.visitor.name : self.contactData.name)
		with tag('br')
		with('span')
			text(serviceResponse)
		serviceDescription = docD.getvalue()
		
		docDD.asis('</p>')
		with tagDD('p')
			textDD(queryResponse)
		docDD.asis('</body>')
		queryDescription = docDD.getvalue()
		
		
        return {
            'theme': stateMessage,
            'startmessage': helloMessage,
            'svc': serviceDescription,
            'q': queryDescription
        }
    def _findContact():
