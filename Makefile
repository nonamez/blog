.SILENT:

include ./docker-compose/.env

help:
	echo
	echo "  Commands for \"$(APP_NAME)\" project: "
	echo
	echo "  help     - Show available commands"
	echo "  up       - \"docker-compose up --remove-orphans\""
	echo "  recreate - \"docker-compose up --remove-orphans --force-recreate\""
	echo "  build    - \"docker-compose up --remove-orphans --build\""
	echo "  down     - \"docker-compose down\""
	echo "  exec-php - Exec into PHP container with \"sh\""
	echo

up:
	docker-compose --env-file ./docker-compose/.env -p $(APP_NAME) -f ./docker-compose/docker-compose.yml up $(ARGS) --remove-orphans

recreate: ARGS := --force-recreate
recreate: up

build: ARGS := --build
build: up

down:
	docker-compose -p $(APP_NAME) -f ./docker-compose/docker-compose.yml down

stop:
	docker-compose -p $(APP_NAME) -f ./docker-compose/docker-compose.yml stop

exec-php:
	docker exec -itu nobody $(APP_NAME)-php /bin/sh