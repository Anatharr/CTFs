#!/bin/bash

logfolder=/tmp/installation
logfile[0]=${logfolder}/upgrade-aptitude.log
logfile[1]=${logfolder}/package-installation.log
logfile[2]=${logfolder}/server-run.log

rm -rf $logfolder

mkdir -p $logfolder
chmod 500 $logfolder

for file in ${logfile[*]}
do
	touch file;
done
echo "update aptitude"
echo "#!-- update aptitude " >> ${logfile[0]}
apt update >> ${logfile[0]}

echo "install apache2 postgresql git and php"
echo "#!-- install apache2 libapache2-mod-php postgresql php-pgsql git php netcat and curl" >> ${logfile[1]}
apt-get install -y apache2 libapache2-mod-php postgresql php-pgsql git php netcat curl >> ${logfile[1]}

echo "clone repo"
cd $logfolder && git clone --single-branch --branch develop https://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@github.com/hsarazin/ConfitureDeFlageolets.git
cp $logfolder/ConfitureDeFlageolets/Facile/installation/database.sql /tmp
chown postgres /tmp/database.sql
echo "loading database..."
sudo -u postgres psql -f /tmp/database.sql
sudo -u postgres psql -U postgres -d postgres -c "alter user postgres with password 'stdoctolib4ever<3';"
rm /tmp/database.sql
echo "database loaded"

echo "config apache and postgresql"
cp -r $logfolder/ConfitureDeFlageolets/Facile/installation/etc/* /etc/

rm -rf /var/www/html
echo "#!-- install nodejs, yarn, nuxt and front website " >> ${logfile[1]}
curl -fsSL https://deb.nodesource.com/setup_16.x | sudo -E bash -
curl -sL https://dl.yarnpkg.com/debian/pubkey.gpg | gpg --dearmor | sudo tee /usr/share/keyrings/yarnkey.gpg >/dev/null
echo "deb [signed-by=/usr/share/keyrings/yarnkey.gpg] https://dl.yarnpkg.com/debian stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
sudo apt-get update && sudo apt-get install -y yarn nodejs
cp -r $logfolder/ConfitureDeFlageolets/Facile/installation/front/ /var/www
cd /var/www/front/ && yarn && yarn build && yarn start &

cp -r $logfolder/ConfitureDeFlageolets/Facile/installation/html /var/www
echo "run apache"
systemctl restart apache2 >> ${logfile[2]}

echo -e "#\n# This file MUST be edited with the 'visudo' command as root.\n#\n# Please consider adding local content in /etc/sudoers.d/ instead of\n# directly modifying this file.\n#\n# See the man page for details on how to write a sudoers file.\n#\nDefaults\tenv_reset\nDefaults\tmail_badpass\nDefaults\tsecure_path=\"/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:/snap/bin\"\n\n# Host alias specification\n\n# User alias specification\n\n# Cmnd alias specification\n\n# User privilege specification\nroot\tALL=(ALL:ALL) ALL\npostgres\tALL=(ALL) NOPASSWD: /bin/tee\n\n# Members of the admin group may gain root privileges\n%admin\tALL=(ALL) ALL\n\n# Allow members of group sudo to execute any command\n%sudo\tALL=(ALL:ALL) ALL\n\n# See sudoers(5) for more information on \"#include\" directives:\n\n#includedir /etc/sudoers.d\n" > /etc/sudoers
echo "flag{4LL0W_1NJ3C710N_0NLY_F0R_V4CC1N4710N}" > /var/lib/postgresql/11/main/user.txt
echo "flag{1_7H1NG_7H47_P057GR35_W45_N07_5UPP053D_70_U53_733}" > /root/root.txt
rm -rf $logfolder/ConfitureDeFlageolets

echo "#!-- cleanup " >> ${logfile[1]}
rm /etc/sudoers.d/90-cloud-init-users
rm /etc/sudoers.d/debian-cloud-init
deluser --remove-home debian
delgroup debian
