.PHONY: build composer composer-install composer-update

UID=$(shell id -u)
GID=$(shell id -g)

DOCKER_IMAGE=sql-documentor
DOCKER_CMD=docker run --rm -v `pwd`:/project -u ${UID}:${GID} $(DOCKER_IMAGE)
COMPOSER_CMD=docker run --rm -v `pwd`:/project -w /project -u ${UID}:${GID} --entrypoint composer $(DOCKER_IMAGE)
CODECEPT_CMD=docker run --rm -v `pwd`:/project -w /project -u ${UID}:${GID} --entrypoint ./vendor/bin/codecept $(DOCKER_IMAGE)

build:
	@docker build -t ${DOCKER_IMAGE} .

composer:
	${COMPOSER_CMD} ${CMD}

composer-install:
	@${COMPOSER_CMD} install

composer-update:
	@${COMPOSER_CMD} update

codecept:
	@${CODECEPT_CMD} ${CMD}

test:
	@${CODECEPT_CMD} run --steps

#run: clear
run:
	docker-compose run --rm php

up:
	docker-compose up -d mysql
	docker-compose run --rm php

down:
	docker-compose down -v

clear:
	@rm -f docs/*.md

daux:
	docker run --rm -it -w /build -v $(shell pwd):/build -u ${UID}:${GID} daux/daux.io daux
