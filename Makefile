.PHONY: build composer

UID=$(shell id -u)
GID=$(shell id -g)

DOCKER_IMAGE="sql-documentor"
DOCKER_CMD=docker run --rm -it -v `pwd`:/project -u ${UID}:${GID} $(DOCKER_IMAGE)

build:
	docker build -t ${DOCKER_IMAGE} .

composer:
	${DOCKER_CMD} composer ${CMD}
