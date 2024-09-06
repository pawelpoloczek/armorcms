build-nginx:
	docker compose -f docker-nginx/docker-compose.yml build
start-nginx:
	docker compose -f docker-nginx/docker-compose.yml up -d
stop-nginx:
	docker compose -f docker-nginx/docker-compose.yml down --remove-orphans
build-apache:
	docker compose -f docker-apache/docker-compose.yml build
start-apache:
	docker compose -f docker-apache/docker-compose.yml up -d
stop-apache:
	docker compose -f docker-apache/docker-compose.yml down --remove-orphans