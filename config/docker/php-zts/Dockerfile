FROM php:7.2-zts

RUN apt-get update && \
    apt-get install -y \
    curl \
    git \
    libicu-dev \
    libpq-dev \
    locales \
    locales-all

RUN docker-php-ext-install pdo pdo_pgsql

ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer; \
    chmod +x /usr/local/bin/composer
RUN echo 1
RUN git clone https://github.com/krakjoe/pthreads.git && \
    cd pthreads && \
    phpize && \
    ./configure && \
    make && \
    make install

COPY ./symfony.ini /usr/local/etc/php/conf.d

ENTRYPOINT ["tail", "-f", "/dev/null"]
