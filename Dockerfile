# docker/Dockerfile
FROM php:8.1-fpm

ARG APCU_VERSION=5.1.22

# Get frequently used tools
RUN apt-get update && apt-get install -y \
    build-essential \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libssl-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libjpeg-dev \
    locales \
    zip \
    unzip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    git \
    curl \
    wget \
    zsh


RUN docker-php-ext-configure zip

RUN docker-php-ext-install \
    bcmath \
    mbstring \
    pcntl \
    intl \
    zip \
    pdo_mysql \
    opcache \
    sockets

RUN docker-php-ext-install sockets
# apcu for caching, xdebug for debugging and also phpunit coverage
RUN pecl install \
    apcu-${APCU_VERSION} \
    mongodb \
    xdebug \
    && docker-php-ext-enable \
    mongodb \
    apcu \
    xdebug

# RUN docker-php-ext-install pdo pdo_mysql 
# Install Nginx
# install gnupg
RUN apt-get update && apt-get install -y \
    gnupg
RUN apt-key adv --keyserver keyserver.ubuntu.com --recv-keys ABF5BD827BD9BF62
RUN apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 4F4EA0AAE5267A6C
RUN echo "deb http://nginx.org/packages/ubuntu/ trusty nginx" >> /etc/apt/sources.list
RUN echo "deb-src http://nginx.org/packages/ubuntu/ trusty nginx" >> /etc/apt/sources.list
RUN apt-get update

## INSTALL GD
RUN docker-php-ext-configure gd --with-jpeg && \
    docker-php-ext-install gd



RUN apt-get install -y nginx

ADD config/default /etc/nginx/sites-enabled/
ADD config/nginx.conf /etc/nginx/
#------------- Supervisor Process Manager ----------------------------------------------------
ADD config/www.conf /etc/php/8.0/fpm/pool.d/www.conf
# Install supervisor
RUN apt-get install -y supervisor
RUN mkdir -p /var/log/supervisor
ADD config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf


RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# install php-redis
RUN pecl install redis && docker-php-ext-enable redis

# php-cs-fixer tool
RUN wget https://cs.symfony.com/download/php-cs-fixer-v2.phar -O /usr/local/bin/php-cs-fixer
RUN chmod +x /usr/local/bin/php-cs-fixer


# Copy existing app directory
COPY . /var/www/html
WORKDIR /var/www/html

# Configure non-root user.
ARG PUID=1001
ENV PUID ${PUID}
ARG PGID=1001
ENV PGID ${PGID}


RUN groupadd -g 1001 go \
    && useradd -m -u 1001 -g go go


RUN chown -R go:go /var/www
RUN chown -R 1001:1001 /var/log/supervisor
RUN chown -R 1001:1001 /etc/supervisor/conf.d/supervisord.conf
# Copy and run composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
# USER go
RUN composer install --no-interaction --ignore-platform-reqs
# RUN cp .env.production .env
RUN chmod 777 -R /var/www/html/storage


EXPOSE 80 

ENTRYPOINT ["/usr/bin/supervisord"]
