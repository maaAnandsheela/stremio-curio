# stremio-curio


This is a [Stremio](https://www.stremio.com/) add-on for [curio](https://curio.io/) which is a paid audio journalism app.

It is a php and apache app and can be run on major free hosting service.

Demo : https://stremio-curio-two.now.sh/manifest.json

## Features

- Includes custom Configuration for most of the things.
- Includes Home Feed of curio.io on discover tab of stremio and the providers as genres.
- Supports Docker Installation.
- Caching the requests in file cache.
- Since its php and apache app can be deployed on any free hosting with cloudflare to support free ssl.
- Includes now.json for deploying on zeit.co
- Supports skip and genres.
- Gives mp3 link of stream playable in stremio and external article of the news.

## Deploying with Docker (preferred for localhost)

To Run on Docker Container

```bash
git clone https://github.com/maaAnandsheela/stremio-curio
cd stremio-curio
docker build -t stremio-curio .
docker run --name scurio -d -p 80:80 stremio-curio
```

To Stop the container

```bash
docker stop scurio
```

## Deploying on zeit.co

- Already Includes now.json to deploy on zeit.co
- Make sure you dont change the cache path before deploying on Zeit. Default is /tmp/data.json.


## Configuration 

- Includes a config.php to config the default variables before setup.
- And other basic manifest variables can also be configured from config.php


## Screenshots

![Screenshot](/captures/screenshot1.png)

![Screenshot](/captures/screenshot2.png)

