#include "server.h"

extern int client;
extern int server;
extern int cam_manager;

int main (int argc, char **argv) {

	server = create_server();

	serve(server);

	cleanup();

	return 0;
}
