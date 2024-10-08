# ArmorCMS

Content Management System for dedicated sites and applications.

## Setup project locally

For linux environment:
- make build
- make start

For Windows environment run these commands in your terminal:
to start:
    docker compose -f docker/docker-compose.yml build
to build:
    docker compose -f docker/docker-compose.yml up -d
    docker exec armorcms-apache bin/composer install
    docker exec armorcms-apache php bin/console doctrine:schema:drop --full-database --force --no-interaction
    docker exec armorcms-apache php bin/console doctrine:migrations:migrate --no-interaction
    docker exec armorcms-apache php bin/console doctrine:fixtures:load --no-interaction
    docker exec armorcms-apache php bin/console armorcms:setup-upload-directories