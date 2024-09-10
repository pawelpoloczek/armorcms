build:
	docker compose -f docker/docker-compose.yml build
start:
	docker compose -f docker/docker-compose.yml up -d
	sleep 1
	docker exec armorcms-apache bin/console doctrine:schema:drop --full-database --force --no-interaction
	docker exec armorcms-apache bin/console doctrine:migrations:migrate --no-interaction
	docker exec armorcms-apache bin/console doctrine:fixtures:load --no-interaction
stop:
	docker compose -f docker/docker-compose.yml down --remove-orphans
fixtures:
	docker exec armorcms-apache bin/console doctrine:migrations:migrate --no-interaction
	docker exec armorcms-apache bin/console doctrine:fixtures:load --no-interaction