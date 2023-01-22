import re
from xml.dom import pulldom

inpt = """
<!DOCTYPE foo [ <!ENTITY xxe SYSTEM "file:///etc/passwd"> ]>
dfgdfgdfg
<p>
	test
</p>
gdfgdfg
<p>
	test
</p>
dfgdfgdf
<p>
	test
</p>
"""

pattern = re.compile('(<!.+?>.+?)?<(?P<tag>.*)( .+)*>.*?</(?P=tag)>', re.DOTALL)
docs = [m for m in re.finditer(pattern, inpt)]

for doc in docs:
	print(inpt[doc.start():doc.end()])
	print('---')

doc = pulldom.parseString(inpt[docs[0].start():docs[0].end()])

for e,n in doc:
	print(e,n)

