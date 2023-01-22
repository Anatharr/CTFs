from xml.sax import parseString
from xml.sax.handler import ContentHandler
import re

class Handler(ContentHandler):

	whitelist = ('a', 'div', 'span', 'i', 'br', 'b', 'h1', 'h2', 'h3', 'h4', 'h5', 'pre', 'strong', 'p', 'table', 'tbody', 'tr', 'th', 'td', 'svg', 'ul', 'li')

	def startDocument(self):
		self.lastParsedDoc = ''

	def startElement(self, name, attrs):
		if name in Handler.whitelist and name!='br':
			self.lastParsedDoc += '<'+name+' '.join(['']+[name+'="'+attrs.getValue(name)+'"' for name in attrs.getNames()])+'>'

	def characters(self, content):
		self.lastParsedDoc += content

	def endElement(self, name):
		if name in Handler.whitelist:
			if name=='br':
				self.lastParsedDoc += '<br/>'
			else:
				self.lastParsedDoc += '</'+name+'>'

	def endDocument(self):
		pass

	def safeParse(self, inpt):
		pattern = re.compile('<(?P<tag>.*)( .+)*>.*</(?P=tag)>', re.DOTALL)
		docs = [m for m in re.finditer(pattern, inpt)]
		if not docs:
			return inpt
		parsedInpt = inpt[:docs[0].start()]
		for doc in docs:
			print(inpt[doc.start():doc.end()+1])
			parseString(inpt[doc.start():doc.end()+1], self)
			parsedInpt += self.lastParsedDoc
		parsedInpt += inpt[docs[-1].end():]

		return parsedInpt


# inpt = """<!DOCTYPE svg [<!ENTITY test2 SYSTEM "http://localhost:8000/test">]>
# 	<svg width="256px" height="256px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1">
# 		<text font-size="16" x="0" y="16">&test2;</text>
# 	</svg>
# """


inpt = """
<p style='bonjour'>
	coucou1
	<br/>
	<script>
		<a>test</a>
		alert('cheh')
	</script>
	coucou2
</p>
"""


xml = Handler().safeParse(inpt)
print(xml)