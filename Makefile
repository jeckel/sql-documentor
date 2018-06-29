.PHONY: build composer composer-install composer-update

UID=$(shell id -u)
GID=$(shell id -g)

DOCKER_IMAGE=jeckel/sql-documentor:latest
DOCKER_CMD=docker run --rm -v `pwd`:/project -w /project -u ${UID}:${GID} $(DOCKER_IMAGE)
COMPOSER_CMD=docker run --rm -v `pwd`:/project -w /project -u ${UID}:${GID} --entrypoint composer $(DOCKER_IMAGE)
CODECEPT_CMD=docker run --rm -v `pwd`:/project -w /project -u ${UID}:${GID} --entrypoint ./vendor/bin/codecept $(DOCKER_IMAGE)

hook-install:
	@if [ -f .git/hooks/pre-commit -o -L .git/hooks/pre-commit ]; then rm .git/hooks/pre-commit; fi
	@cd .git/hooks/ && ln -s ../../hooks/precommit.sh pre-commit

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
	@${CODECEPT_CMD} run --steps --coverage --coverage-html

cs:
	${DOCKER_CMD} ./vendor/bin/phpcs --standard=PSR2 --extensions=php --ignore=./tests/_support/* ./src ./tests

md:
	${DOCKER_CMD} ./vendor/bin/phpmd ./src text cleancode

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
