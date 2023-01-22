FROM debian

RUN apt-get update && apt-get install -y \
		apache2 \
		git \
		libapache2-mod-php \
		php \
		cron\
	&& rm -r /var/www

COPY www /var/www
COPY openvpn /root/.openvpn

RUN chown www-data:www-data /var/www/html/sponsors \
	&& mkdir /var/www/receipts \
	&& chown www-data:www-data /var/www/receipts \
	&& chown www-data:www-data /var/www/flag.txt \
	&& chmod 400 /var/www/flag.txt \
	&& echo "# /etc/crontab: system-wide crontab\n# Unlike any other crontab you don't have to run the \`crontab'\n# command to install the new version when you edit this file\n# and files in /etc/cron.d. These files also have username fields,\n# that none of the other crontabs do.\n\nSHELL=/bin/sh\nPATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin\n\n# Example of job definition:\n# .---------------- minute (0 - 59)\n# |  .------------- hour (0 - 23)\n# |  |  .---------- day of month (1 - 31)\n# |  |  |  .------- month (1 - 12) OR jan,feb,mar,apr ...\n# |  |  |  |  .---- day of week (0 - 6) (Sunday=0 or 7) OR sun,mon,tue,wed,thu,fri,sat\n# |  |  |  |  |\n# *  *  *  *  * user-name command to be executed\n*  *\t* * *\troot\tcd / && run-parts --report /etc/cron.minutely\n17 *\t* * *\troot\tcd / && run-parts --report /etc/cron.hourly\n25 6\t* * *\troot\ttest -x /usr/sbin/anacron || ( cd / && run-parts --report /etc/cron.daily )\n47 6\t* * 7\troot\ttest -x /usr/sbin/anacron || ( cd / && run-parts --report /etc/cron.weekly )\n52 6\t1 * *\troot\ttest -x /usr/sbin/anacron || ( cd / && run-parts --report /etc/cron.monthly )\n#" > /etc/crontab \
	&& mkdir  /etc/cron.minutely \
	&& touch /etc/cron.minutely/backup \
	&& chmod +x /etc/cron.minutely/backup \
	&& mkdir /tmp/backups \
	&& echo "#!/bin/sh\n\n# Add all new factures to a tar archive so we can retreive\n# them easily with 'docker cp' every 2 minutes from the host\n\nmv /var/www/receipts/* /tmp/backups/\ncd /tmp/backups\nif [ -e /var/backups/receipts.tar ]\nthen\n\ttar -uf /var/backups/receipts.tar *\nelse\n\ttar -cf /var/backups/receipts.tar *\nfi\n\nrm /tmp/backups/*" > /etc/cron.minutely/backup \
	&& echo "FLAG{i7_I5_N0t_F1nI5H3d_Y3T_!!}" > /root/flag.txt \
	&& chmod 400 /root/flag.txt

EXPOSE 80

CMD cron && apache2ctl -D FOREGROUND
