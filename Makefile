all: help
#.PHONY: help status build composer-install build-container start stop shell test

current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

help: Makefile
	@sed -n 's/^##//p' $<

## status:	Show containers status
status:
	@docker-compose ps

## build:		Start container and install packages
build: build-container start

## build-container:Rebuild a container
build-container:
	@docker-compose up --build --force-recreate --no-deps -d

## start:		Start container
start:
	@docker-compose up -d

## stop:		Stop containers
stop:
	@docker-compose stop

## down:		Stop containers and remove stopped containers and any network created
down:
	@docker-compose down

## destroy:	Stop containers and remove its volumes (all information inside volumes will be lost)
destroy:
	@docker-compose down -v

## shell:		Interactive shell inside docker
shell:
	@docker-compose exec php_app sh
