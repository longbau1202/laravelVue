# docker image base
ARG BASE_NGINX=nginx:1.21.5-alpine
ARG BASE_PHP=php:8.1.0-fpm-alpine

FROM $BASE_NGINX as nginx-builder
COPY .docker/nginx/templates/* /etc/nginx/templates/
## php-fpm-alpine-builder image: install common php extension need for project
FROM $BASE_PHP AS php-fpm-alpine-builder
LABEL maintainer="thinhld <thinhld@vnext.vn>"
ENV TZ=Asia/Tokyo
ENV PYTHONUNBUFFERED=1
RUN set -eux; \
        \
        apk update; \
        \
        echo "CHANGE TIME ZONE TO '$TZ' AT BUILD TIME ONLY"; \
            apk add --no-cache tzdata; \
            cp /usr/share/zoneinfo/$TZ /etc/localtime; \
            echo $TZ > /etc/timezone; \
            echo "Test current date: $(date)"; \
            echo "timezone will reset to UTC if we run command 'apk del tzdata' so no run command until this bug fixed by alpine maintainer"; \
        \
        echo "INSTALL  PHP EXTENSION NEEDED 'pdo_mysql' 'opcache'"; \
            apk add --no-cache --virtual .build-deps $PHPIZE_DEPS; \
            docker-php-ext-install -j "$(nproc)" pdo_mysql; \
        \
        echo 'CLEAN UP TEMP TO REDUCE DOCKER IMAGE SIZES'; \
        rm -rf /tmp/* /var/cache/apk/*

## php-fpm-prod image: install php extension support for production env
FROM php-fpm-alpine-builder AS php-fpm-prod

# tag help inspect docker image in the future
ARG GIT_COMMIT_HASH=unspecified
ARG GIT_BRANCH_NAME=unspecified

LABEL maintainer="hungtd <hungtd@vnext.vn>" \
    git.commit=$GIT_COMMIT_HASH \
    git.branch=$GIT_BRANCH_NAME
RUN set -eux; \
        \
        docker-php-ext-enable opcache; \
        cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"; \
        \
        echo 'CLEAN UP TEMP TO REDUCE DOCKER IMAGE SIZES'; \
        rm -rf /tmp/* /var/cache/apk/*
COPY .docker/php/conf.d/z-opcache.prod.ini .docker/php/conf.d/z-php.prod.ini $PHP_INI_DIR/conf.d/

#####################################################################################################################
## laravelvue-public: bundle  public source code (js,css). use this image on read-only env (production, staging) ##
#####################################################################################################################
FROM nginx-builder as laravelvue-public

# tag help inspect docker image in the future
ARG GIT_COMMIT_HASH=unspecified
ARG GIT_BRANCH_NAME=unspecified

LABEL maintainer="hungtd <hungtd@vnext.vn>" \
    git.commit=$GIT_COMMIT_HASH \
    git.branch=$GIT_BRANCH_NAME

WORKDIR /var/www/html/laravelvue/public
COPY .docker/nginx/conf.d/laravelvue-app.conf /etc/nginx/conf.d/default.conf
COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY --chown=nginx:nginx public .
EXPOSE 80

##########################################################################################################
## laravelvue-vendor ##
##########################################################################################################
FROM composer:2.3.5 AS vendor
WORKDIR /var/www/html/laravelVue
COPY --chown=www-data:www-data composer.json artisan ./
RUN set -eux; \
composer install \
        --quiet \
        --ignore-platform-reqs \
        --no-interaction \
        --no-progress \
        --no-suggest \
        --no-scripts \
        --prefer-dist \
        --no-autoloader \
        --no-dev;
##########################################################################################################
## laravelvue-app: bundle  web app source code. use this image on read-only env (production, staging) ##
##########################################################################################################
FROM php-fpm-prod AS laravelvue-app

# tag help inspect docker image in the future
ARG GIT_COMMIT_HASH=unspecified
ARG GIT_BRANCH_NAME=unspecified

LABEL maintainer="hungtd <hungtd@vnext.vn>" \
    git.commit=$GIT_COMMIT_HASH \
    git.branch=$GIT_BRANCH_NAME

ENV APPLICATION_ENV=production

WORKDIR /var/www/html/laravelVue
COPY --chown=www-data:www-data app app
COPY --chown=www-data:www-data bootstrap bootstrap
COPY --chown=www-data:www-data config config
COPY --chown=www-data:www-data database database
COPY --chown=www-data:www-data lang lang
COPY --chown=www-data:www-data storage storage
COPY --chown=www-data:www-data resources resources
COPY --chown=www-data:www-data routes routes

COPY --chown=www-data:www-data composer.json artisan modules_statuses.json ./
COPY --chown=www-data:www-data public/*.php public/mix-manifest.json public/
COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer
COPY --from=vendor --chown=www-data:www-data /var/www/html/laravelVue/vendor /var/www/html/laravelVue/vendor
VOLUME ["/var/www/html/laravelVue/storage/app/public"]
RUN set -eux; \
        echo "$GIT_BRANCH_NAME - $GIT_COMMIT_HASH" > VERSION; \
        echo "DUMP autoload class for production"; \
        cd /var/www/html/laravelvue && \
        composer dumpautoload -a;

CMD ["php-fpm"]
EXPOSE 9000

## php-fpm-dev image: install php extension support for developer
FROM php-fpm-alpine-builder AS php-fpm-dev
ARG USER_ID=1000
ARG GROUP_ID=1000
ENV COMPOSER_CACHE_DIR=/tmp
WORKDIR /var/www/html/laravelVue
RUN set -eux; \
        echo "INSTALL NPM nodejs, Xdebug"; \
            apk add nodejs-current;\
            apk add --update npm;\
            apk add --no-cache --virtual .build-deps $PHPIZE_DEPS; \
            pecl install xdebug-3.1.2; \
            docker-php-ext-enable xdebug; \
        \
        apk del .build-deps; \
        cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"; \
        \
        echo 'CLEAN UP TEMP TO REDUCE DOCKER IMAGE SIZES'; \
        rm -rf /tmp/* /var/cache/apk/*
COPY .docker/php/conf.d/z-xdebug.dev.ini .docker/php/conf.d/z-php.dev.ini $PHP_INI_DIR/conf.d/
COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer
