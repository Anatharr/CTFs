#ifndef SERVER_HEADER
#define SERVER_HEADER

#include <stdio.h>
#include <string.h>
#include <errno.h>
#include <stdlib.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <sys/stat.h>
#include <sys/un.h>
#include <sys/syscall.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include <unistd.h>
#include <signal.h>

#define BUF_SIZE 256
#define PORT 9122
#define HOST INADDR_ANY
#define CAMERA_DIR "/tmp/cameras/"
#define CAMERA_DIR_LEN 14 // Don't forget the null byte !

void panic(const char *msg);
int create_server();
int accept_client(int server);
int open_camera(char *buf, int len);
void serve(int server);
void cleanup();

extern int client;
extern int server;
extern int cam_manager;

#endif