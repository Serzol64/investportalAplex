import re


def Cost(q):
	validStatus = []
	
	if not q >= 10000:
		validStatus.append('The minimum amount of the object is 1000')
	
	return validStatus

def Attribute(q):
	validStatus = []
	
	if q == 'any':
		validStatus.append('Attribute not selected')	
			
	return validStatus
