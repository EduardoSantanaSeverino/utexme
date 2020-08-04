#!/bin/bash
sudo echo "Installing Docker Engine - Community"
sudo echo "1. Update the apt package index:"
sudo apt-get update

sudo echo "2. Install packages to allow apt to use a repository over HTTPS:"
sudo apt-get install \
    apt-transport-https \
    ca-certificates \
    curl \
    gnupg-agent \
    software-properties-common
    
sudo echo "3. Add Docker’s official GPG key:"
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -

sudo echo "4. Use the following command to set up the stable repository. "
sudo add-apt-repository \
   "deb [arch=amd64] https://download.docker.com/linux/ubuntu \
   $(lsb_release -cs) \
   stable"

sudo echo "INSTALL DOCKER ENGINE - COMMUNITY"

sudo echo "1. Update the apt package index."
sudo apt-get update
sudo echo "2. Install the latest version of Docker Engine - Community and containerd, or go to the next step to install a specific version:"
sudo apt-get install docker-ce docker-ce-cli containerd.io
sudo echo "3. To install a specific version of Docker Engine (Skiped)"
sudo echo "4. Verify that Docker Engine - Community is installed correctly by running the hello-world image."
sudo docker run hello-world

sudo echo "Install Docker Compose"
sudo echo "Install Compose"

sudo echo "1. Run this command to download the current stable release of Docker Compose:"
sudo curl -L "https://github.com/docker/compose/releases/download/1.25.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose

sudo echo "2. Apply executable permissions to the binary:"
sudo chmod +x /usr/local/bin/docker-compose

sudo echo "3. Note: If the command docker-compose fails after installation,"
sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose

sudo echo "4. Test your version"
docker-compose --version