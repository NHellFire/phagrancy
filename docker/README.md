# Deploy phagrancy with docker

Example how to run phagrancy app, on-premise Vagrant cloud, with docker.
One container with nginx and php-fpm is used.

## Build the docker image

    docker-compose build

## Prepare .env configuration file

See `.env.sample` and docs [wiki/.env-Configuration-File](https://github.com/dlundgren/phagrancy/wiki/.env-Configuration-File).

**Note:** Variable names are uppercase for docker.

It is supposed that `STORAGE_PATH=boxes`, this path will be mounted into
the phagrancy docker container. See [docker-compose.yml](docker-compose.yml).

php-fpm is running with user:group `www-data:www-data` (`33:33`).

## Create a directory to store vagrant boxes

    mkdir boxes
    chown 33:33 boxes

## Start phagrancy docker container

    docker-compose up

## Enabling SSL

It's recommended to use a reverse proxy to provide SSL, but you can enable it in phagrancy as [documented here](https://serversideup.net/open-source/docker-php/docs/customizing-the-image/configuring-ssl).

## Manually generating a self-signed certificate

    mkdir certs
    openssl \
        req \
        -nodes \
        -x509 \
        -newkey rsa:4096 \
        -keyout certs/phagrancy.local.key \
        -out certs/phagrancy.local.crt \
        -days 365 \
        -subj "/C=UA/L=Kyiv/O=Company name/OU=IT/CN=phagrancy.local"
