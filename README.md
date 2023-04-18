# Erykia 👩🏻
### Artificial Intelligence in all languages 🌎

🤖 Artificial intelligence for creating websites, systems in php with restfull api

### Terminal exec
INSTALL MAC OS AND LINUX
```shell
bash <(curl -S 'https://install.erykia.com')
```

INSTALL WINDOWS
`require git https://git-scm.com/`
`require docker https://www.docker.com/`
```shell
git clone https://github.com/Erykai/erykia.git --depth=1
cd erykia
docker compose up -d --build
```

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
      "null": true,
      "input": "text"
    },
    "dislike":{
      "type": "int(11)",
      "null": true,
      "input": "text"
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
      "input": "upload"
    }
  }
}
```
Example country.
##### send post https://lvh.me/module or https://localhost/module raw json
```json
{
  "component": "country",
  "database": {
    "name":{
      "type": "varchar(100)",
      "input": "text"
    },
    "iso3":{
      "type": "char(3)",
      "null": true,
      "input": "text"
    },
    "numeric_code":{
      "type": "char(3)",
      "null": true,
      "input": "text"
    },
    "iso2":{
      "type": "char(2)",
      "null": true,
      "input": "text"
    },
    "phonecode":{
      "type": "varchar(255)",
      "null": true,
      "input": "text"
    },
    "capital":{
      "type": "varchar(255)",
      "null": true,
      "input": "text"
    },
    "currency":{
      "type": "varchar(255)",
      "null": true,
      "input": "text"
    },
    "currency_name":{
      "type": "varchar(255)",
      "null": true,
      "input": "text"
    },
    "currency_symbol":{
      "type": "varchar(255)",
      "null": true,
      "input": "text"
    },
    "tld":{
      "type": "varchar(255)",
      "null": true,
      "input": "text"
    },
    "native":{
      "type": "varchar(255)",
      "null": true,
      "input": "text"
    },
    "region":{
      "type": "varchar(255)",
      "null": true,
      "input": "text"
    },
    "subregion":{
      "type": "varchar(255)",
      "null": true,
      "input": "text"
    },
    "timezones":{
      "type": "text",
      "null": true,
      "input": "text"
    },
    "translations":{
      "type": "varchar(255)",
      "null": true,
      "input": "text"
    },
    "latitude":{
      "type": "decimal(10,8)",
      "null": true,
      "input": "text"
    },
    "longitude":{
      "type": "decimal(11,8)",
      "null": true,
      "input": "text"
    },
    "emoji":{
      "type": "varchar(191)",
      "null": true,
      "input": "text"
    },
    "emojiU":{
      "type": "varchar(191)",
      "null": true,
      "input": "text"
    },
    "flag":{
      "type": "tinyint(1)",
      "input": "text"
    },
    "wikiDataId":{
      "type": "varchar(255)",
      "null": true,
      "input": "text"
    }
  }
}
```
Example state.
##### send post https://lvh.me/module or https://localhost/module raw json
```json
{
  "component": "state",
  "database": {
    "id_countries":{
      "type": "int(11)",
      "input": "text"
    },
    "name":{
      "type": "varchar(100)",
      "input": "text"
    },
    "country_code":{
      "type": "char(2)",
      "input": "text"
    },
    "fips_code":{
      "type": "varchar(255)",
      "null": true,
      "input": "text"
    },
    "iso2":{
      "type": "varchar(255)",
      "null": true,
      "input": "text"
    },
    "type":{
      "type": "varchar(191)",
      "null": true,
      "input": "text"
    },
    "latitude":{
      "type": "decimal(10,8)",
      "null": true,
      "input": "text"
    },
    "longitude":{
      "type": "decimal(11,8)",
      "null": true,
      "input": "text"
    },
    "flag":{
      "type": "tinyint(1)",
      "input": "text"
    },
    "wikiDataId":{
      "type": "varchar(255)",
      "null": true,
      "input": "text"
    }
  }
}
```
Example city.
##### send post https://lvh.me/module or https://localhost/module raw json
```json
{
  "component": "city",
  "database": {
    "id_countries":{
      "type": "int(11)default(1)",
      "input": "text"
    },
    "id_states":{
      "type": "int(11)",
      "input": "text"
    },
    "name":{
      "type": "varchar(100)",
      "input": "text"
    },
    "country_code":{
      "type": "char(2)",
      "input": "text"
    },
    "state_code":{
      "type": "varchar(255)",
      "null": true,
      "input": "text"
    },
    "latitude":{
      "type": "decimal(10,8)",
      "null": true,
      "input": "text"
    },
    "longitude":{
      "type": "decimal(11,8)",
      "null": true,
      "input": "text"
    },
    "flag":{
      "input": "text",
      "schema": {
        "type": "tinyint(1)",
        "default": "1"
      }
    },
    "wikiDataId":{
      "type": "varchar(255)",
      "null": true,
      "input": "text"
    }
  }
}
```
