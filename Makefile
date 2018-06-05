.PHONY: build composer composer-install composer-update

UID=$(shell id -u)
GID=$(shell id -g)

DOCKER_IMAGE="jeckel/sql-documentor:latest"
DOCKER_CMD=docker run --rm -v `pwd`:/project -u ${UID}:${GID} $(DOCKER_IMAGE)
COMPOSER_CMD=docker run --rm -v `pwd`:/project -u ${UID}:${GID} --entrypoint composer $(DOCKER_IMAGE)

build: Dockerfile
	@docker build -t ${DOCKER_IMAGE} .

push:
	@docker push ${DOCKER_IMAGE}

composer:
	@${COMPOSER_CMD} ${CMD}
composer-install:
	@${COMPOSER_CMD} install

composer-update:
	@${COMPOSER_CMD} update

run:
	docker-compose run --rm php
	#@${DOCKER_CMD}

up: build
	docker-compose up -d mysql
	echo "Wait mariadb init"
	sleep 10
	docker-compose run --rm php

down:
	docker-compose down -v


#Options:
#  -c, --configuration=CONFIGURATION  Configuration file
#      --value=VALUE                  Set different configuration values (multiple values allowed)
#  -s, --source=SOURCE                Where to take the documentation from
#  -p, --processor=PROCESSOR          Manipulations on the tree
#  -t, --themes=THEMES                Set a different themes directory
#  -f, --format=FORMAT                Output format, html or confluence [default: "html"]
#      --delete                       Delete pages not linked to a documentation page (confluence)
#  -d, --destination=DESTINATION      Destination folder, relative to the working directory [default: "static"]
#      --search                       Generate full text search
#  -h, --help                         Display this help message
#  -q, --quiet                        Do not output any message
#  -V, --version                      Display this application version
#      --ansi                         Force ANSI output
#      --no-ansi                      Disable ANSI output
#  -n, --no-interaction               Do not ask any interactive question
#  -v|vv|vvv, --verbose               Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

daux:
	docker run --rm -it -w /build -v $(shell pwd):/build -u ${UID}:${GID} daux/daux.io daux
