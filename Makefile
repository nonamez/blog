.SILENT:

include ./docker-compose/.env

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
	docker-compose --env-file ./docker-compose/.env -p $(APP_NAME) -f ./docker-compose/docker-compose.yml up $(ARGS)

recreate: ARGS := --force-recreate
recreate: up

build: ARGS := --build
build: up

down:
	docker-compose -p $(APP_NAME) -f ./docker-compose/docker-compose.yml down

exec-php:
	docker exec -itu nobody $(APP_NAME)-php /bin/sh