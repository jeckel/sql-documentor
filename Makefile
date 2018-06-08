.PHONY: build composer composer-install composer-update

UID=$(shell id -u)
GID=$(shell id -g)

DOCKER_IMAGE=sql-documentor
DOCKER_CMD=docker run --rm -v `pwd`:/project -u ${UID}:${GID} $(DOCKER_IMAGE)
COMPOSER_CMD=docker run --rm -v `pwd`:/project -w /project -u ${UID}:${GID} --entrypoint composer $(DOCKER_IMAGE)

build:
	@docker build -t ${DOCKER_IMAGE} .

composer:
	${COMPOSER_CMD} ${CMD}

composer-install:
	@${COMPOSER_CMD} install

composer-update:
	@${COMPOSER_CMD} update

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
