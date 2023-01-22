import socket as s
from time import sleep
from monThread import MonThread

msg = b'hello'

sock = s.socket(s.AF_UNIX, s.SOCK_STREAM)

sock.bind('./uds_server')

sock.listen(1)

con, addr = sock.accept()

recv_Thread = MonThread(con, None)
recv_Thread.start()

while True : 
    con.send(msg)
    sleep(5)
