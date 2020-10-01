# -*- mode: ruby -*-
# vi: set ft=ruby :
# vim: ts=2 sw=2 et

class Hash
  def slice(*keep_keys)
    h = {}
    keep_keys.each { |key| h[key] = fetch(key) if has_key?(key) }
    h
  end unless Hash.method_defined?(:slice)
  def except(*less_keys)
    slice(*keys - less_keys)
  end unless Hash.method_defined?(:except)
end

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|
  # Online Vagrantfile documentation is at https://docs.vagrantup.com.
  
  # The AWS provider does not actually need to use a Vagrant box file.
  config.vm.box = "dummy"

  config.vm.provider :aws do |aws, override|
    # AWS configuration should be set in the environment. Ensure these are
    # accessible.
    #
    # aws.access_key_id = "YOUR KEY"
    # aws.secret_access_key = "YOUR SECRET KEY"
    # aws.session_token = "SESSION TOKEN"

    # The region for Amazon Educate is fixed.
    aws.region = "us-east-1"

    # These options force synchronisation of files to the VM's
    # /vagrant directory using rsync, rather than using trying to use
    # SMB (which will not be available by default).
    override.nfs.functional = false
    override.vm.allowed_synced_folder_types = :rsync

    # Sync only the app directory.
    config.vm.synced_folder "app/", "/vagrant", type: "rsync",
        rsync__exclude: ".git/"

    # The name of the EC2 keypair as set in Amazon.
    aws.keypair_name = "quickreg-kp"
    # The path to the private key on the local machine.
    override.ssh.private_key_path = "~/.ssh/quickreg-kp.pem"

    # Use a cheap t2.micro EC2 instance type.
    aws.instance_type = "t2.micro"

    # The 'Public Web Server" security group
    aws.security_groups = ["sg-..."]

    # The subnet_id and availability zone for the public subnet
    aws.availability_zone = "us-east-1a"
    aws.subnet_id = "subnet-..."

    # Associate a public IP address to an instance in a VPC
    aws.associate_public_ip = true

    # AMI (i.e., hard disk image) to use. The official Ubuntu AMIs can be found
    # at https://cloud-images.ubuntu.com/locator/ec2/
    #
    # AMI for us-east-1 focal hvm
    aws.ami = "ami-0dba2cb6798deb6d8"

    # Connect using the correct username.
    override.ssh.username = "ubuntu"
  end

  # Provisioning shell script. Sets up docker environment, creates tables in
  # Amazon RDS DB instance, and brings up all containers.
  config.vm.provision "shell", inline: <<-SHELL
    apt-get update
    apt-get install -y docker docker-compose python3-pip
    systemctl enable --now docker.service
    usermod -aG docker ubuntu
    cd /vagrant
    python3 -m pip install python-dotenv mysql-connector-python
    python3 db-setup.py
    docker-compose up -d
  SHELL
end
