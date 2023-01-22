#include "server.h"

int client = -1;
int server = -1;
int cam_manager = -1;


void panic(const char *msg) {
	perror(msg);
	cleanup();
	exit(1);
}

int create_server() {
	int	sock = socket(AF_INET,SOCK_STREAM,IPPROTO_TCP);
	struct sockaddr_in addrSrv; // We won't use it after this function

	addrSrv.sin_family = AF_INET;
	addrSrv.sin_addr.s_addr = htonl(HOST);
	addrSrv.sin_port = htons(PORT);

	if (bind(sock, (struct sockaddr *)&addrSrv, sizeof(struct sockaddr_in)) == -1) {
		panic("Error while binding");
	}

	listen(sock, 16);
	printf("Listening on port %d.\n", PORT);

	return sock;
}

void cleanup() {
	if (client != -1) close(client);
	if (server != -1) close(server);
	if (cam_manager != -1) {
		write(cam_manager, "exit", 4);
		close(cam_manager);
	}
}

int accept_client(int sock) {
	socklen_t addrSize = sizeof(struct sockaddr_in);
	struct sockaddr_in addrClient;

	int client = accept(sock, (struct sockaddr *)&addrClient, &addrSize);
	if (client == -1) {
		panic("Error while accepting connection");
	}

	printf("Received client %s:%d\n", inet_ntoa(addrClient.sin_addr), ntohs(addrClient.sin_port));
	return client;
}

int open_camera(char *buf, int len) {
	int	sock = socket(AF_UNIX, SOCK_STREAM, 0);
	struct sockaddr_un addrCam; 
	struct stat statbuf;

	char *path = (char*) malloc(len + CAMERA_DIR_LEN);
	strcpy(path, CAMERA_DIR);
	strcat(path, buf);
	path[len + CAMERA_DIR_LEN -1] = '\0';

	if (access(path, F_OK) == 0) {
		if (stat(path, &statbuf) < 0) {
			panic("Error while stating file");
		}
		if (!S_ISSOCK(statbuf.st_mode)) {
			errno = EBADF;
			panic("Error while checking camera socket");
		}
	} else {
		errno = ENOENT;
		panic("Error while checking camera socket");
	}

	addrCam.sun_family = AF_UNIX;
	strncpy(addrCam.sun_path, path, 108);

	if (connect(sock, (struct sockaddr *)&addrCam, sizeof(addrCam)) < 0) {
		panic("Cannot open camera");
	}

	return sock;
}

void serve(int server) {
	char *buf = (char*) malloc(BUF_SIZE/2);
	
	int n, len;
	int process_running = 1;

	signal(SIGCHLD,SIG_IGN);

	while (process_running) {
		client = accept_client(server);

		switch (fork()) {
			case -1:
				panic ("Error while forking parent process");
				break;

			case 0: // Child
				n = read(client, buf, BUF_SIZE/2);
				cam_manager = open_camera(buf, n);
				write(cam_manager, "get_status", 10);

				printf("Opened Camera : %s\n", buf);
				char sendBuffer[BUF_SIZE];
				snprintf(sendBuffer, BUF_SIZE, "Copyright camera manager 2021, version \033[94mbeta \033[92m1.0\033[0m\n\033[33mStatus of camera \033[0m\033[90m[\033[34m%s\033[90m]\033[0m : ", buf); len = 112+n;
				n = read(cam_manager, sendBuffer+len, BUF_SIZE); len += n;
				write(client, sendBuffer, len);

				process_running = 0;
				break;

			default: // Parent
				close(client);
		}
	}
}