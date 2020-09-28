# QuickREG

A simple solution to quickly collect registrations for an event.

## Quick start

## Local build

You must have a working installation of `docker` and `docker-compose`.

1. Run `docker-compose --env-file .env.example up -d`
2. Browse to [localhost](http://localhost) for the public web interface
3. Browse to [localhost:8080](http://localhost:8080) for the phpMyAdmin
   console. The default root password is `root`.

## Deploy to EC2

You must have a working installation of Vagrant along with the AWS plug-in and
`aws-cli`.

```bash
# Install the AWS plug-in and download dummy box
vagrant plugin install vagrant-aws
vagrant box add dummy https://github.com/mitchellh/vagrant-aws/raw/master/dummy.box
```

1. Export your aws credentials (as defined in `~/.aws/credentials`). You should ensure
`AWS_ACCESS_KEY_ID` `AWS_SECRET_ACCESS_KEY` and `AWS_SESSION_TOKEN` are defined.
2. Ensure you have generated valid EC2 keypair named `quickreg` with the
private key located at ~/.ssh/quickreg.pem`.
3. Add AWS Security Group IDs for web access (port `80` and `8080`) and ssh
(`22`) to the `Vagrantfile`.

## Images used

This project is based upon a Docker LEMP stack. As such, the following images
are used.

Image | Tag
--- | ---
[Nginx](https://hub.docker.com/_/nginx) | `1.19-alpine`
[PHP](https://hub.docker.com/_/php) | `7.4-fpm-alpine`
[MySQL](https://hub.docker.com/_/mysql) | `8.0`
[phpMyAdmin](https://hub.docker.com/_/phpmyadmin) | `5-fpm-alpine`

## Usage

> **NOTE:** Environment variables are used to configure the containers. An
example environment file `.env.example` is included within this repository.
This file should be copied to `.env` and configured as required (e.g. change
default passwords) before starting the project for the first time.

The quickest way to build and start all containers in the background.

```bash
docker-compose up -d
```

### Useful commands

View running containers

```bash
docker-compose ps
```

Tail the container's logs

```bash
docker-compose logs -f [service]
```

Stop and/or destroy all containers

```bash
docker-compose stop
```

Stop and/or destroy all containers along with associated volumes

```bash
docker-compose down -v
```

Start a basic shell inside a container

```bash
docker-compose exec <service> bash
```
