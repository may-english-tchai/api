#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

if [ ! -f composer.json ]; then
    rm -Rf tmp/

    git config --global user.email "you@example.com"
    git config --global user.name "Your Name"

    symfony new --webapp tmp

    cd tmp
    rm -rf docker-compose* .git
    symfony composer require "php:>=$PHP_VERSION"
    symfony composer config --json extra.symfony.docker 'true'
    cp -Rp . ..
    cd -

    rm -Rf tmp/
else
	make composer-install
fi

test -f env.local || touch .env.local

make jwt-generate
make doctrine-migrate

chmod -R 777 ./

# if app_env = dev load fixtures
if [ "$APP_ENV" = "dev" ]; then
	make doctrine-fixtures
fi
exec docker-php-entrypoint "$@"
