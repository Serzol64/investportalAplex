import sys
import json
from asyncio.windows_events import NULL
import mysql.connector
from decimal import Decimal
import socket

from objectConnector import Cost, Attribute
from dataConnector import Title, Content, Description, Region, presentationUpload, photoGallery

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

def formGenerator(t):
    if t == 'header':
		readyForm = {
			{
				'stepN': 1,
				'stepT': 'Entering personal data about the object'
			},
			{
				'stepN': 2,
				'stepT': 'Selecting an object attribute'
			},
			{
				'stepN': 3,
				'stepT': 'Enter the country where this object is located'
			},
			{
				'stepN': 4,
				'stepT': 'Upload photos and video presentation of this object'
			},
			{
				'stepN': 5,
				'stepT': 'Enter brief information about your investment object and its parameters'
			},
			{
				'stepN': 6,
				'stepT': 'Object presentation(No require)'
			}
		}
	elif t == 'body':
		readyForm = {
			{
				'type': 'default',
				'stepD': 'Enter the name of the object and its value in dollars. If you are only interested in the currency of your region, it will be important for us that many investors are interested in your object. Depending on the currency that the user has chosen in the portal services, it automatically converts dollars into any currency, thanks to the technology of daily conversion. You can transfer the amount of any currency to the dollar <a href="http://bit.do/converter_to_USD" target="_blank">here</a>.',
				'form': {
					{
						'name': 'Object title',
						'fieldName': 'objectTitle',
						'dExample': 'Hotel Reddison',
						'dSource': None,
						'dMethod': None,
						'optionData': None
					},
					{
						'name': 'Object cost(in USD)',
						'fieldName': 'objectCost',
						'dExample': '10 000',
						'dSource': None,
						'dMethod': None,
						'optionData': None
					}
					
				}
			},
			{
				'type': 'list',
				'stepD': 'Choose the attribute that your object is most likely to relate to!',
				'form': {
					{
						'listTitle': 'Object attribute',
						'listName': 'objectAttribute',
						'dExample': None,
						'dSource': None,
						'dMethod': None,
						'optionData': {}
					}
					
				}
			},
			{
				'type': 'search',
				'stepD': 'Enter the first letters and the autofill technology will give you an accurate list of countries on request, where you can quickly select the country of the world you need, for which information about the object is placed',
				'form': {
					{
						'name': 'Object country',
						'fieldName': 'objectRegion',
						'dExample': 'Spain',
						'dSource': '/services/3/get',
						'dMethod': 'GET',
						'optionData': None
					}
					
				}
			},
			{
				'type': 'upload',
				'stepD': 'Upload more than one photo and one video presentation that will help investors uncover more opportunities when making deals with your object',
				'form': {
					{
						'name': 'Photogallery',
						'fieldName': 'photogallery',
						'dExample': 'Upload photos',
						'dSource': None,
						'dMethod': None,
						'optionData': None
					},
					{
						'name': 'Video presentation',
						'fieldName': 'presentation',
						'dExample': 'Upload video presentation',
						'dSource': None,
						'dMethod': None,
						'optionData': None
					},
					{
						'name': 'Video presentation poster',
						'fieldName': 'presentationPoster',
						'dExample': 'Upload video presentation poster',
						'dSource': None,
						'dMethod': None,
						'optionData': None
					},
					
				}
			},
			{
				'type': 'queryContent',
				'stepD': 'Describe your object and its features. Then specify the filters and parameters of your object in the "filter - value" format in accordance with the data filtering standards set in the selected attribute',
				'form': {
					{
						'name': 'Object description',
						'fieldName': 'description',
						'dExample': 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sodales neque sodales ut etiam sit amet nisl. At lectus urna duis convallis convallis tellus. Risus pretium quam vulputate dignissim suspendisse. Neque laoreet suspendisse interdum consectetur libero. Odio pellentesque diam volutpat commodo sed. Sed pulvinar proin gravida hendrerit lectus. Volutpat lacus laoreet non curabitur. Arcu dui vivamus arcu felis bibendum ut tristique et egestas. Eu facilisis sed odio morbi quis. Malesuada fames ac turpis egestas.',
						'dSource': None,
						'dMethod': None,
						'optionData': None
					},
					{
						'name': 'Object parameters',
						'fieldName': 'content',
						'dExample': '',
						'dSource': None,
						'dMethod': None,
						'optionData': None
					},
					
				}
			}
			{
				'type': 'upload',
				'stepD': 'Download only one presentation file in PDF format!',
				'form': {
					{
						'name': 'PDF Presentation Data',
						'fieldName': 'presentationFile',
						'dExample': 'Max size - 500 MB',
						'dSource': None,
						'dMethod': None,
						'optionData': None
					}
					
				}
			}
		}
	elif t == 'footer':
		readyForm = {
			{ 'isLast': False },
			{ 'isLast': False },
			{ 'isLast': False },
			{ 'isLast': False },
			{ 'isLast': False },
			{ 'isLast': True }
		}
		
	return { 'fieldGen': readyForm }

def formValid(q):
	validResponse = []
	fieldsQuery = q.multivalidator
	
	for i in range(len(fieldsQuery.fieldsName)):
		currentName = fieldsQuery.fieldsName[i]
		currentValue = fieldsQuery.fieldsValue[i]
		
		if currentName == 'photogallery' or currentName == 'presentation' or currentName == 'presentationFile' or :
			if currentName == 'presentation':
				vValidation = presentationUpload('video', currentValue)
				
				if vValidation:
					validResponse.append(vValidation)
			elif currentName == 'presentationFile':
				fValidation = presentationUpload('file', currentValue)
				
				if fValidation:
					validResponse.append(fValidation)
			elif currentName == 'presentationPoster':
				pValidation = presentationPosterUpload('video', currentValue)
				
				if pValidation:
					validResponse.append(fValidation)
			else:
				pgValidation = photoGallery(currentValue)
				
				if pgValidation:
					validResponse.append(pgValidation)

		elif currentName == 'objectTitle' or currentName == 'objectCost':
			isCost = currentValue == 'objectCost' if Cost(currentValue) else Title(currentValue)
			validResponse.append(isCost)
		elif currentName == 'description' or currentName == 'content':
			isContent = currentValue == 'content' if Content(currentValue) else Description(currentValue)
			validResponse.append(isContent)
		elif currentName == 'objectAttribute' or currentName == 'objectRegion':
			isAttribute = currentValue == 'objectAttribute' if Attribute(currentValue) else Region(currentValue)
			validResponse.append(isAttribute)
			
    return validResponse

if __name__ == "__main__":
	
	if "--userQuery" in sys.argv[0]:
		readyQuery = sys.args[0].strip("--userQuery=")
		readyQuery = json.loads(readyQuery)
		
		if readyQuery.service == 'getForm':
			readyResponse = {
				'steps': {
					'header': formGenerator('header'),
					'content': formGenerator('body'),
					'footer': formGenerator('footer'),
				}
			}
			
			print(json.dumps(readyResponse))
