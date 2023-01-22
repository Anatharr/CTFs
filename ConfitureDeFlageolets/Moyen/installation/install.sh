#!/bin/bash

# --- Configuration --- #
gh_token=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
gh_branch=main
gh_path=Moyen/installation
# --------------------- #


# Prepare environment
cwd=/tmp/installation
esc=$(printf '\033')
rm -rf $cwd
mkdir $cwd
chmod 600 $cwd
touch $cwd/installation.log
echo -e "color=34\nif [ \"\$1\" == 'status' ]\n\tthen\n\t\tcolor=93\n\telif [ \"\$1\" == 'info' ]\n\tthen\n\t\tcolor=90\n\telif [ \"\$1\" == 'step' ]\n\tthen\n\t\tcolor=92\n\telif [ \"\$1\" == 'error' ]\n\tthen\n\t\tcolor='91;1'\nfi\n\nwhile read line;do\n\techo \"${esc}[90m[\$(date +'%H:%M:%S')]${esc}[0m ${esc}[\${color}m(\$1)${esc}[0m \${line}\" >> $cwd/installation.log\ndone" >> $cwd/log
chmod +x $cwd/log
echo "Started installation script" | $cwd/log step

# Install dependencies
echo "Installing Depedencies ..." | $cwd/log status
{
	apt-get update
	apt-get install -y \
	    git \
	    ca-certificates \
	    curl \
	    gnupg \
	    lsb-release \
	    cron \
	    openvpn
} 2>&1 | $cwd/log dependencies

# Install docker
echo "Installing Docker Engine ..." | $cwd/log status
{
	curl -fsSL https://download.docker.com/linux/debian/gpg | gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg
	echo \
		"deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/debian \
		$(lsb_release -cs) stable" | tee /etc/apt/sources.list.d/docker.list > /dev/null
	apt-get update
	apt-get install -y docker-ce=5:19.03.0~3-0~debian-buster docker-ce-cli=5:19.03.0~3-0~debian-buster containerd.io
} 2>&1 | $cwd/log install_docker


# Retrieve all required data from our repo
# WARNING: This repo contains all our CTFs, this url (and especially the token) must remain totally secret, this is why we delete it afterwards
echo "Cloning Github repo ..." | $cwd/log status
{
	git clone -b $gh_branch --single-branch https://$gh_token@github.com/hsarazin/ConfitureDeFlageolets.git $cwd/repo

	cp -r $cwd/repo/$gh_path/openvpn $cwd/
	cp -r $cwd/repo/$gh_path/www $cwd/
	cp -r $cwd/repo/$gh_path/Dockerfile $cwd/

	rm -rf $cwd/repo
} 2>&1 | $cwd/log git

# Build and run docker image
echo "Building docker container ..." | $cwd/log status
{
	# Using DockerHub
	#docker login -u anatharr -p $dh_token
	#docker pull anatharr/rockit
	#docker logout
	#docker run -ditp 80:80 anatharr/rockit

	# Rebuilding it from Dockerfile
	cd $cwd/
	docker build -t rockit --network host .
	docker run --network bridge --name rockit_container -ditp 80:80 rockit
} 2>&1 | $cwd/log docker

# Configure Cron
echo "Configuring Cron ..." | $cwd/log status
{
	echo -e "*/2  *    * * *   root    docker cp rockit_container:/var/backups/receipts.tar /var/backups/receipts.tar\n#" >> /etc/crontab

} 2>&1 | $cwd/log configure_cron

# Setup Openvpn
echo "Configuring and running Openvpn ..." | $cwd/log status
{
	cp -r $cwd/openvpn /root/.openvpn
	cd /root/.openvpn
	openvpn /root/.openvpn/config.ovpn
} 2>&1 | $cwd/log openvpn

# Configure iptables
#echo "Configuring iptables ..." | $cwd/log status
#{
#	# Allow established sessions to receive traffic
#	iptables -A INPUT -m conntrack --ctstate ESTABLISHED,RELATED -i tun0 -j ACCEPT
#
#	# Drop incoming connections on tun0
#	iptables -A INPUT -i tun0 -j DROP
#} 2>&1 | $cwd/log iptables

# Add root flag
echo "Adding root flag ..." | $cwd/log status
{
	echo 'FLAG{y0u_jU5t_R0cK3d_1T_t0_ThE_M0oN}' >> /root/root.txt
	chmod 400 /root/root.txt

} 2>&1 | $cwd/log add_flag

# Cleanup
echo "Cleaning up ..." | $cwd/log status
{
	cp $cwd/installation.log /var/log/installation.log
	chmod 600 /var/log/installation.log
	rm -rf $cwd/
	ln -s /dev/null /root/.bash_history
	rm /etc/sudoers.d/90-cloud-init-users
	rm /etc/sudoers.d/debian-cloud-init
	deluser --remove-home debian
	delgroup debian
} 2>&1  | sed -e "s/^/${esc}[90m[$(date +'%H:%M:%S')]${esc}[0m ${esc}[34m(cleanup)${esc}[0m /" >> /var/log/installation.log
echo "${esc}[90m[$(date +'%H:%M:%S')]${esc}[0m ${esc}[92;1m(status)${esc}[0m Finished installation script !" >> /var/log/installation.log
