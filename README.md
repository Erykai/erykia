# Erykia 👩🏻
### Artificial Intelligence in all languages 🌎

🤖 Artificial intelligence for creating websites, systems in php with restfull api

### MODE INSTALL
`require git https://git-scm.com/` 
`require docker https://www.docker.com/` 
### REQUIRE
`composer`
`php: >=8.0`
`ext-pdo`
`ext-curl`
`docker`
### Terminal exec
UP
```shell
git clone https://github.com/Erykai/erykia.git
cd erykia
docker compose up -d --build
```

###### terminal exec
DOWN
```shell
docker compose down
```

VERIFY ERROR
```shell
docker compose ps
```

LOGS PHP
```shell
docker compose logs php
```

#### Open your browser and go to https://lvh.me or https://localhost
##### PMA http://lvh.me:8080

### DATABASE
      - HOST=mysql
      - USER=root
      - PASSWORD=root
      - DATABASE=erykia
      - DRIVER=mysql

### CREATE NEW MODULE EXAMPLE JSON
Example streaming and category.
##### send post https://lvh.me/module or https://localhost/module raw json
```json
{
  "component": "streaming",
  "database": {
    "id_streamings_categories":{
      "type": "int(11)",
      "input": "select"
    },
    "id_countries":{
      "type": "int(11)",
      "input": "select"
    },
    "id_states":{
      "type": "int(11)",
      "input": "select"
    },
    "id_cities":{
      "type": "int(11)",
      "input": "select"
    },
    "name":{
      "type": "varchar(255)",
      "input": "text"
    },
    "subtitle":{
      "type": "text",
      "input": "textarea"
    },
    "description":{
      "type": "text",
      "input": "textarea"
    },
    "tag":{
      "type": "text",
      "null": true,
      "input": "text"
    },
    "url":{
      "type": "varchar(255)",
      "input": "text"
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
      "type": "text",
      "input": "text"
    },
    "cover":{
      "type": "text",
      "null": true,
      "input": "upload"
    }
  },
  "category": {
    "name": {
      "type": "varchar(255)",
      "input": "text"
    },
    "slug": {
      "type": "text",
      "input": "text"
    },
    "cover": {
      "type": "text",
      "null": true,
      "upload": "text"
    }
  }
}
```
