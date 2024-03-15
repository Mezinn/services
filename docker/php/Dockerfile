FROM alpine:3.19

RUN apk add --update --no-cache \
    curl \
    bash \
    git \
    shadow \
    php83-phar \
       php83 \
       php83-iconv \
       php83-mbstring \
       php83-ctype \
       php83-xml \
       php83-dom \
       php83-tokenizer \
       php83-session \
       php83-simplexml \
       php83-pecl-amqp \
       php83-pecl-redis \
       php83-pdo \
       php83-pdo_mysql



RUN ln -s /usr/bin/php83 /usr/bin/php

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash; \
    apk add --update --no-cache\
    symfony-cli

RUN groupmod -g 1000 www-data; \
    useradd -u 1000 -g www-data -m www-data
