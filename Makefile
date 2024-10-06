build:
	docker compose -f docker/docker-compose.yml build
start:
	docker compose -f docker/docker-compose.yml up -d
	docker exec armorcms-apache bin/composer install
	docker exec armorcms-apache php bin/console doctrine:schema:drop --full-database --force --no-interaction
	docker exec armorcms-apache php bin/console doctrine:migrations:migrate --no-interaction
	docker exec armorcms-apache php bin/console doctrine:fixtures:load --no-interaction
	docker exec armorcms-apache php bin/console armorcms:setup-upload-directories
stop:
	docker compose -f docker/docker-compose.yml down --remove-orphans
diff:
	docker exec armorcms-apache php bin/console doctrine:migrations:diff --no-interaction
migrate:
	docker exec armorcms-apache php bin/console doctrine:migrations:migrate --no-interaction
fixtures:
	docker exec armorcms-apache php bin/console doctrine:migrations:migrate --no-interaction
	docker exec armorcms-apache php bin/console doctrine:fixtures:load --no-interaction