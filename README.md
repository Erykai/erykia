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

### DATABASE DEFAULT
      - HOST = mysql
      - USER = root
      - PASSWORD = root
      - DATABASE  = erykia
      - DRIVER = mysql

### CREATE NEW MODULE EXAMPLE JSON

##### send post https://lvh.me/module or https://localhost/module raw json
open the modules_mind folder and see several examples of json for creating new modules
