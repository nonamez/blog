.SILENT:

include ./docker/.env

help:
	echo
	echo "  Commands for \"$(APP_NAME)\" project: "
	echo
	echo "  help     - Show available commands"
	echo "  up       - \"docker-compose up\""
	echo "  recreate - \"docker-compose up --force-recreate\""
	echo "  build    - \"docker-compose up --build\""
	echo "  down     - \"docker-compose down\""
	echo "  exec-php - Exec into PHP container with \"sh\""
	echo

up:
	docker-compose --env-file ./docker/.env -p $(APP_NAME) -f ./docker/docker-compose.yml up $(ARGS) --remove-orphans

recreate: ARGS := --force-recreate
recreate: up

build: ARGS := --build
build: up

down:
	docker-compose -p $(APP_NAME) -f ./docker/docker-compose.yml down

stop:
	docker-compose -p $(APP_NAME) -f ./docker/docker-compose.yml stop

exec-php:
	docker exec -it $(APP_NAME)-php bash

exec-mysql:
	docker exec -itu root $(APP_NAME)-mysql bash