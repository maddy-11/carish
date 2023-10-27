INSTALLING COMPOSE LINK.

https://linuxize.com/post/how-to-install-and-use-docker-compose-on-ubuntu-18-04/


Containerize This: PHP/Apache
===================================

### Intro
This is created for PHP SLIM API's
It is ALPINE version with many dependencies installed with
Base on Docker-Compse


```
/php-apache/
├── Dockerfile
├── docker-compose.yml
├── start.sh
```

 
#### index.php
http://localhost:3000/index.php/guest/hello

### Docker Compose

version: "3.1"
services:
  web:
    build: .(Build image of existing directory)
    ports:
      - "3000:80" (It will run on port 3000)
    volumes:
      - /var/www/html/bw_services:/app/public/ (Project working directory)
      - /var/run/mysqld/mysqld.sock:/var/run/mysqld/mysqld.sock (If database connection issue occures then try to connect host MYSQL socket to Docker )
    container_name: Carish-Services (This will be the service name)

### Compose Run command.

docker-compose run

