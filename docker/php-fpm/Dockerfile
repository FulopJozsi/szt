FROM phpdockerio/php:8.1-fpm

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y install \
            nodejs \
            php-imagick \
            php8.1-common \
            php8.1-redis \
            php8.1-bcmath \
            php8.1-cli \
            php8.1-curl \
            php8.1-gd \
            php8.1-json \
            php8.1-mbstring \
            #php8.1-mysql \
            php8.1-pdo \
            php8.1-xml \
            php8.1-intl \
            php8.1-zip \
            mysql-client \
            php-mysql \
    && apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install apps only dev, not prod
RUN apt-get update \
    && apt-get -y --no-install-recommends install \
            git \
            mc \
            pv \
            vim \
    && apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer
RUN composer global require laravel/installer \
  && echo 'export PATH="$HOME/.composer/vendor/bin:$PATH"' >> $HOME/.bashrc


RUN apt-get update \
    && apt-get -y install \
        php-mysql

# Add user
RUN groupadd -g 1000 szallas && \
	useradd -u 1000 -ms /bin/bash -g szallas szallas && \
	touch /run/php-fpm.pid && \
	chown szallas:szallas /run/php-fpm.pid

COPY --chown=szallas:szallas . /application

WORKDIR "/application"

USER szallas
