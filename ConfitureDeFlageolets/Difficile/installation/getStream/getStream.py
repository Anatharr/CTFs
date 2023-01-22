import socket
from monThread import MonThread

cam_name  = '1'
cam_path = '/tmp/cameras/'
sock_addr  = cam_path + cam_name



cam_sock = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)
atk_sock = socket.socket(socket.AF_UNIX, socket.SOCK_STREAM)

# connect to camera 
# cam_sock.connect(sock_addr)

# A COMMENTER APRES LES TESTS 
cam_sock.connect('./uds_server')

#connect to atk
atk_sock.connect(sock_addr)
# Ask for stream

# Thread to recv command from the atk
recvThread = MonThread(atk_sock, cam_sock)
recvThread.start()

# send camera's stream to the atk
while True : 
    stream = cam_sock.recv(1024)
    atk_sock.send(stream)
    
