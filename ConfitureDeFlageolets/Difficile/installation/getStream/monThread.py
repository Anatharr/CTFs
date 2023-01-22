import threading


class MonThread (threading.Thread):
    def __init__(self, recv_sock, send_sock ):      
        threading.Thread.__init__(self, daemon=True)  
        self.recv_sock   = recv_sock
        self.send_sock = send_sock
        self.running = False

    def run(self):
        self.running = True
        while(self.running):
            
            data = self.recv_sock.recv(512)

            # IF ONLY FOR DEBUG CAN BE DROP AFTER TEST 
            if self.send_sock is None:
                print(data)
            else:
                self.send_sock.send(data)   