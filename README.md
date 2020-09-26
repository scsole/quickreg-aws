# QuickREG

A simple solution to quickly collect registrations for an event.

## Quick start

You must have a working installation of `docker` and `docker-compose`.

1. Clone and `cd` into this repo
2. Run `docker-compose --env-file .env.example up -d`
3. Browse to [localhost](http://localhost) for the public web interface
4. Browse to [localhost:8080](http://localhost:8080) for the phpMyAdmin
   console. The default root password is `root`.

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
