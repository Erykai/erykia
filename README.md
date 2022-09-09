# Erykia
###Artificial Intelligence in all languages

Artificial intelligence for creating websites, systems in php with restfull api

### MODE INSTALL
Download the latest version, unzip it on a php server, composer install, composer update, create database mysql or mariadb
and that's it! Now access your url, and Erykia will talk to you, to create your website or your system in PHP :)

### INSTALL DOCKER https://www.docker.com/
######terminal exec
UP
```
docker-compose up -d --build
or
docker compose up -d --build
```

######terminal exec
DOWN
```
docker-compose down
or
docker compose down
```

VERIFY ERROR
```
docker-compose ps

docker compose ps
```

LOGS PHP
```
docker-compose logs php
or
docker compose logs php
```
### CREATE NEW MODULE EXAMPLE JSON
Example streaming and category.
##### send post https://lvh.me/module or https://localhost/module raw json
```json
{
  "component": "streaming",
  "namespace": "stream",
  "database": {
    "id_streamings_categories":{
      "type": "int(11)"
    },
    "id_countries":{
      "type": "int(11)"
    },
    "id_states":{
      "type": "int(11)"
    },
    "id_cities":{
      "type": "int(11)"
    },
    "name":{
      "type": "varchar(255)"
    },
    "subtitle":{
      "type": "text"
    },
    "description":{
      "type": "text"
    },
    "tag":{
      "type": "text",
      "null": true
    },
    "url":{
      "type": "varchar(255)"
    },
    "like":{
      "type": "int(11)",
      "null": true
    },
    "dislike":{
      "type": "int(11)",
      "null": true
    },
    "slug":{
      "type": "text"
    },
    "cover":{
      "type": "text",
      "null": true
    }
  },
  "category": {
    "name": {
      "type": "varchar(255)"
    },
    "slug": {
      "type": "text"
    },
    "icon": {
      "type": "text",
      "null": true
    }
  }
}
```
### REQUIRE
`composer`
`php: >=8.0`
`ext-pdo`
`ext-curl`
`docker`
