FROM php:8.0.2-fpm-buster

ENV USER_NAME=webuser
ENV HOME=/home/$USER_NAME
ENV COMPOSER_HOME=$HOME/.composer
ENV PATH ./vendor/bin:$COMPOSER_HOME/vendor/bin:$PATH
ENV COMPOSER_MEMORY_LIMIT=-1

RUN apt update \
    && DEBIAN_FRONTEND=noninteractive apt install -yqq --fix-missing \
    apt-utils \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    zlib1g-dev \
    libzip-dev \
    default-mysql-client \
    zip \
    unzip \
    nano \
    supervisor \
    && apt clean \
    && rm -rf /var/lib/apt/lists/*

    RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd soap \
    xml iconv simplexml zip

    RUN pecl install xdebug \
        && docker-php-ext-enable xdebug \
        && docker-php-source delete

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY ./etc/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY ./etc/php/php.ini /usr/local/etc/php/conf.d

RUN adduser --disabled-password --gecos "" ${USER_NAME} \
    && echo "${USER_NAME}  ALL = ( ALL ) NOPASSWD: ALL" >> /etc/sudoers \
    && mkdir -p /var/www/html \
    && chmod -R 755 /var/www/html \
    && mkdir -p $COMPOSER_HOME \
    && chown -R ${USER_NAME}:${USER_NAME} /var/www $HOME \
    && rm -rf ~/.composer/cache/* \
    && chown -R ${USER_NAME}:${USER_NAME} $COMPOSER_HOME

RUN apt autoremove -yqq --purge \
    && apt autoclean -yqq \
    && apt clean \
    && rm -rf /var/cache/apt/ /var/lib/apt/lists/* /var/log/* /tmp/* /var/tmp/* /usr/share/doc /usr/share/doc-base /usr/share/groff/* /usr/share/info/* /usr/share/linda/* /usr/share/lintian/overrides/* /usr/share/locale/* /usr/share/man/* /usr/share/locale/* /usr/share/gnome/help/*/* /usr/share/doc/kde/HTML/*/* /usr/share/omf/*/*-*.emf

USER $USER_NAME

WORKDIR /var/www/html
EXPOSE 9000
CMD ["php-fpm"]