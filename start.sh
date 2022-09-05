#version PHP -> 56, 70, 72, 73, 74, 80 or 81
#erikia requer >=80
phpVersion="80"
#folder system example
pathProject="/Applications/XAMPP/xamppfiles/htdocs/alexdeovidal/erykia/"
pathFile="vendor/alexdeovidal/docker-dev/php-"$phpVersion"-docker-compose.yml up -d"
#path docker-composer
/usr/local/bin/docker-compose -f $pathProject$pathFile