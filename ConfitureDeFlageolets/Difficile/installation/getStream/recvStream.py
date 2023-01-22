import socket
from pathlib import Path
from time import sleep


cam_name  = '1'
cam_path  = '/tmp/cameras/'
atk_addr  = cam_path + cam_name

# create file in /tmp/cameras in order to store the camera's stream
Path(cam_path).mkdir(parents=True, exist_ok=True)

atk_server = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)

atk_server.bind(atk_addr)

atk_server.listen(1)

con, addr = atk_server.accept()

#ask for camera's stream
con.send(b'getStream')

while True :

    stream  = con.recv(1024)
    print('atk recv : ', stream)
    con.send(b'ls -l')    
    sleep(9)

