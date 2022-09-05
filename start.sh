#version PHP -> 56.yml, 70.yml, 72.yml, 73.yml, 74.yml, 80.yml or 81.yml
#erikia requer >=80
phpVersion="80"
#folder system example
pathProject="/Applications/XAMPP/xamppfiles/htdocs/alexdeovidal/erykia/"
pathFile="vendor/alexdeovidal/docker-dev/"$phpVersion".yml up -d"
#path docker-composer
/usr/local/bin/docker-compose -f $pathProject$pathFile