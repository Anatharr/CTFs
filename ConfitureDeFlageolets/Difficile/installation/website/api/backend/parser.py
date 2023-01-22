from xml.dom import pulldom, minidom
from xml.parsers.expat import ExpatError
from xml.sax._exceptions import SAXParseException
import re

tagWhitelist = [
	'a', 'div', 'span',
	'i', 'br', 'b', 'h1',
	'h2', 'h3', 'h4', 'h5',
	'pre', 'strong', 'p',
	'table', 'tbody', 'tr',
	'th', 'td', 'svg', 'ul',
	'li'
]

def safeParse(inpt):
	pattern = re.compile('(<!.+?>.+?)?<(?P<tag>.*)( .+)*>.*?</(?P=tag)>', re.DOTALL)
	docs = [m for m in re.finditer(pattern, inpt)]
	if not docs:
		return inpt
	index = 0
	parsedInpt = ''
	for doc in docs:
		parsedInpt += inpt[index:doc.start()]
		index = doc.end()
		doc = pulldom.parseString(inpt[doc.start():doc.end()])

		parents = []; gotContent = {}
		try:
			parsedDoc = ''
			for event, node in doc:
				if event=='START_ELEMENT':
					parents.append(node)
					gotContent[node] = False
					if node.tagName in tagWhitelist and all([elem.tagName in tagWhitelist for elem in parents]):
						parsedDoc += '<'+node.tagName+' '.join(['']+[k+'="'+v+'"' for k,v in node.attributes.items() if k[:2]!='on'])+'>'
				elif event=='CHARACTERS':
					if all([elem.tagName in tagWhitelist for elem in parents]):
						parsedDoc += node.data
						gotContent[parents[-1]] = True
				elif event=='END_ELEMENT':
					parents.pop()
					if node.tagName in tagWhitelist and all([elem.tagName in tagWhitelist for elem in parents]):
						if gotContent[node]:
							parsedDoc += '</'+node.tagName+'>'
						else:
							parsedDoc = parsedDoc[:-1]
							parsedDoc += '/>'
			parsedInpt += parsedDoc
		except (ExpatError, SAXParseException):
			pass

	parsedInpt += inpt[index:]

	return parsedInpt
