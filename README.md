# Erykia
###Artificial Intelligence in all languages

Artificial intelligence for creating websites, systems in php with restfull api

### MODE INSTALL
if you want to use another installation and configuration other than with Docker, just comment out all the lines in start.sh
and skip the next step.

OR
Requires sh installation on your operating system
Open start.sh and configure MAC and install Docker https://docs.docker.com/

```shell
#version PHP -> 56, 70, 72, 73, 74, 80 or 81
#erikia requer >=80
phpVersion="80"
#folder system example
pathProject="/Applications/projects/erykia.com/"
pathFile="vendor/alexdeovidal/docker-dev/php-"$phpVersion"-docker-compose.yml up -d"
#path docker-composer
/usr/local/bin/docker-compose -f $pathProject$pathFile
```

Download the latest version, unzip it on a php server, composer install, composer update, create database mysql or mariadb
and that's it! Now access your url, and Erykia will talk to you, to create your website or your system in PHP :)

### REQUIRE
`composer`
`php: >=8.0`
`ext-pdo`
`ext-curl`
