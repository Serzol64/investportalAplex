import magic
import base64
import re
import socket, mysql.connector

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


def Title(q):
	validStatus = []
	
	if q == '':
		validStatus.append('Title not entered')
	else:
		isEnglish = re.match(r"[A-Z][a-z]", q)
		
		if not isEnglish:
			validStatus.append('In the name of the object, only English is most often used!')
		
	return validStatus

def Description(q):
	validStatus = []
	
	if q == '':
		validStatus.append('Description not entered')
	else:
		isEnglish = re.match(r"[A-Z][a-z][0-9]", q)
		
		if not isEnglish:
			validStatus.append('In the name of the object, only English is most often used! Or try to use numerical data in the description in order to increase the accessibility of studying this object by portal users.')
		
	return validStatus

def Region(q):
	validStatus = []
	
	if q == 'any':
		validStatus.append('Region not entered')	
			
	return validStatus

def Content(q):
	validStatus = []
	if q == '':
		validStatus.append('Content data not entered')
	else:
		newStringsCount = q.text.count("\n") - 1
		isFormat = q.split(' - ')
		
		if isFormat:
			if not isFormat.end() == newStringsCount:
				validStatus.append('')
			else:
				magicResponse = []
				errorText = ''
				findParam = {
					'field': isFormat[0]
				}
				
				cnlx.execute(('SELECT type as "type" FROM objectdata_filter WHERE field = %field'), findParam)
				
				for (typ) in cnlx:
					if typ == 'int':
						if re.match(r"[0-9]", isFormat[2]):
							magicResponse.append(True)
						else:
							magicResponse.append(False)
					elif typ == 'precentable':
						if re.match(r"[0-9]", isFormat[2]) and isFormat[2].split('%'):
							magicResponse.append(True)
						else:
							magicResponse.append(False)
					elif typ == 'selecting':
						if isFormat[2] == 'Yes' or isFormat[2] == 'No':
							magicResponse.append(True)
						else:
							magicResponse.append(False)
					elif typ == 'text':
						if re.match(r"[A-Z][a-z][0-9]", isFormat[2]):
							magicResponse.append(True)
						else:
							magicResponse.append(False)
							
				if not magicResponse[1]:
					errorText += 'The ' +  isFilter[0] + ' filter value has a percentage value (For example: ' + isFilter[0] + ' - 50%)\n'	
				elif not magicResponse[0]:
					errorText += 'The ' +  isFilter[0] + ' filter value has a integer value (For example: ' + isFilter[0] + ' - 100)\n'	
				elif not magicResponse[2]:
					errorText += 'The ' +  isFilter[0] + ' filter value has a selecting value (For example: ' + isFilter[0] + ' - Yes or No)\n'	
				elif not magicResponse[3]:
					errorText += 'The ' +  isFilter[0] + ' filter value has a default value and English content require only(For example: ' +  + ' - Any text)\n'
					
				validStatus.append(errorText)
		else:
			validStatus.append('The data you entered does not meet the requirements (example of the requirement: "filter - value")')	
		
		
		
	return validStatus


def photoGallery(q):
	validStatus = []
	encodeQuery = q
	
	with magic.Magic() as m:
			mimeIs = m.from_buffer(base64.b64decode(encodeQuery))
			photoFormat = mimeIs == 'image/jpeg' or mimeIs == 'image/gif' or mimeIs == 'image/png' or mimeIs == 'image/webm'
			
			if not photoFormat:
				validStatus.append('Invalid formats of downloadable formats! Files of the appropriate formats are allowed: JPEG, GIF, PNG and WebM')
			else:
				
	return validStatus
	
def presentationUpload(t,q):
	
	validStatus = []
	encodeQuery = q	
	if t == 'video':
		with magic.Magic() as m:
			mimeIs = m.from_buffer(base64.b64decode(encodeQuery))
			videoFormat = mimeIs == 'video/mp4' or mimeIs == 'video/ogg' or mimeIs == 'video/webm'
			
			if not videoFormat:
				validStatus.append('Invalid formats of downloadable formats! Files of the appropriate formats are allowed: MP4, OGV and WebM')
	elif t == 'file':
		with magic.Magic() as m:
			mimeIs = m.from_buffer(base64.b64decode(encodeQuery))
			fileFormat = mimeIs == 'application/pdf'
			
			if not fileFormat:
				validStatus.append('Invalid formats of downloadable formats! Files of the appropriate formats are allowed: Only PDF')
				
	return validStatus

def presentationPosterUpload(t,q):
	
	validStatus = []
	encodeQuery = q	
	if t == 'video':
		with magic.Magic() as m:
			mimeIs = m.from_buffer(base64.b64decode(encodeQuery))
			posterFormat = mimeIs == 'image/jpeg' or mimeIs == 'image/png' or mimeIs == 'image/webm'
			
			if not posterFormat:
				validStatus.append('Invalid formats of downloadable formats! Files of the appropriate formats are allowed: JPEG, GIF, PNG and WebM')
				
	return validStatus

