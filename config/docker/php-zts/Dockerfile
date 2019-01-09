FROM programster/ubuntu16.04-pthreads-7.2

#RUN apt-get update && \
#    apt-get install -y software-properties-common language-pack-en-base
#
#RUN locale-gen en_US.UTF-8 && \
#    export LC_ALL=en_US.UTF-8 && \
#    export LANG=en_US.UTF-8
#
RUN apt-get update && \
    apt-get install -y \
    curl \
    git \
    libicu-dev \
    libpq-dev \
    locales \
    locales-all

#RUN pecl install -o -f \
#    pdo && \
#    pdo_pgsql
#    && \
#    rm -rf /tmp/pear &&  \
#    docker-php-ext-enable pdo && \
#    docker-php-ext-enable pdo_pgsql

ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer; \
    chmod +x /usr/local/bin/composer

RUN usermod -s /bin/bash www-data
#; \
#    touch /var/www/.bash_history; \
#    chmod 777 /var/www/.bash_history

#RUN chown -R www-data:www-data /usr/local/etc/php/; \
#    chmod -R 775 /usr/local/etc/php/

ENV PROMPT_COMMAND="history -a"
ENV HISTTIMEFORMAT="%h %d %H:%M:%S "
ENV HISTFILESIZE=20000
ENV LC_ALL en_US.UTF-8
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US.UTF-8

COPY ./symfony.ini /usr/local/etc/php/conf.d
COPY ./symfony.pool.conf /usr/local/etc/php-fpm.d/