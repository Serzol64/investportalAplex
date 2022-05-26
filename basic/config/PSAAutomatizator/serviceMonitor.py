import smtplib
import telegram-send
import pywhatkit
import fbmessenger
import aioviberbot
import smsru_api

import * as serviceMonitor

class PortalUserNotificator():
    def __init__(contacts, service, query):
        self.contactData = contacts
        self.serviceData = service
        self.queryData = query
    def send():
        return proccessResponse
    def _findContact():


class SMS(PortalUserNotificator):
    def send():
        statusInfo = ''
        if self.queryData.state == 'success':
            if self.serviceData.mode == 'push': statusInfo = 'Your query proccessing success'
            elif self.serviceData.mode == 'realtime': statusInfo = 'Your query consideration success'
    
        currentContact = self._findContact()
        messengerMessage = self._messageGenerator([statusInfo, self.queryData.meta, self.serviceData.meta])

        return proccessResponse
    def _textGenerator(message):
        sdr = message[2]
        qdr = message[1]


        return message[0] + ' ' + serviceDescription + '' + queryDescription

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
        messengerMessage = self._messageGenerator([statusInfo, self.queryData.meta, self.serviceData.meta])

        if currentContact.isWhatsApp:

        elif currentContact.isFB:

        elif currentContact.isViber:

        elif currentContact.isTG:

        return proccessResponse
    def _messageGenerator(message):
        sdr = message[2]
        qdr = message[1]


        return message[0] + ' ' + serviceDescription + '' + queryDescription
    def _findContact():

class EMail(PortalUserNotificator):
    def send():
        statusInfo = ''
        if self.queryData.state == 'success':
            if self.serviceData.mode == 'push': statusInfo = 'Your query proccessing success'
            elif self.serviceData.mode == 'realtime': statusInfo = 'Your query consideration success'
    
        currentContact = self._findContact()
        messengerMessage = self._messageGenerator([statusInfo, self.queryData.meta, self.serviceData.meta])
    
        return proccessResponse    
    def _messageGenerator(message):
        return {
            'theme': stateMessage,
            'startmessage': message[0],
            'svc': serviceDescription,
            'q': queryDescription
        }
    def _findContact():