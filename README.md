# QuickREG

A simple solution to quickly collect registrations for an event.

## Deploy via AWS quick start

Requires `aws`, `vagrant`, and the Vagrant AWS plug-in.

1. Ensure the AWS-CLI has been configured with: `aws configure`
2. Run `./quickreg init`
3. Run `./quickreg start`
4. Browse to the instance's public DNS address for the public web interface
5. Browse to the instance's public DNS address via port `8080` for the
phpMyAdmin console. The default `webuser` password is `webuser_pw`

<details>
<summary>How to install the Vagrant AWS plugin</summary>

```bash
vagrant plugin install vagrant-aws
vagrant box add dummy https://github.com/mitchellh/vagrant-aws/raw/master/dummy.box
```
</details>

## Images used

This project is based upon a Docker LEMP stack. As such, the following images
are used.

Image | Tag
--- | ---
[Nginx](https://hub.docker.com/_/nginx) | `1.19-alpine`
[PHP](https://hub.docker.com/_/php) | `7.4-fpm-alpine`
[MySQL](https://hub.docker.com/_/mysql) | `8.0`
[phpMyAdmin](https://hub.docker.com/_/phpmyadmin) | `5-fpm-alpine`

## Docker usage

> **NOTE:** The following commands can be used on the EC2 instance when in the
`/vagrant` directory. Since only the EC2 instance has access to the Amazon RDS,
it is not possible to run the application locally with database access.

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
docker-compose exec <service> sh
```
