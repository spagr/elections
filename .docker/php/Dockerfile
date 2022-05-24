ARG php_version=8.1.1
ARG debian_version=bullseye
ARG php_mode=fpm

# pridat architekturu 
FROM php:${php_version}-${php_mode}-${debian_version} as php_base
ARG TARGETPLATFORM
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Install php extensions
RUN chmod +x /usr/local/bin/install-php-extensions && \
    sync && \
    install-php-extensions \
    	amqp \
    	bcmath \
    	imap \
    	imagick \
    	gd \
    	intl \
    	mcrypt \
    	yaml \
    	zip \
    	opcache \
    	pdo_mysql \
    	redis

# Install composer 
RUN install-php-extensions @composer && \
    chown www-data:www-data /usr/local/bin/composer

# Install wget & git
RUN apt update && apt install -y wget && apt install -y git

# Install node.js
#ENV NODEJS_VERSION=16.13.1
#
#RUN if [ "$TARGETPLATFORM" = "linux/amd64" ]; then export platform=linux-x64 ; elif [ "$TARGETPLATFORM" = "linux/arm64" ]; then export platform=linux-arm64; else export platform=linux-x86; fi && \
#    wget --quiet http://nodejs.org/dist/v${NODEJS_VERSION}/node-v${NODEJS_VERSION}-${platform}.tar.gz && \
#    tar --strip-components 1 -xzvf node-v* -C /usr/local && \
#    rm -rf node-v*

RUN \wget https://get.symfony.com/cli/installer -O - | bash && mv /root/.symfony/bin/symfony /usr/local/bin/symfony


FROM php_base as php_dev

RUN install-php-extensions xdebug

COPY docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/

# Set UID & GID for php-fpm user to 1000:1000
RUN \
  usermod -u 1000 www-data && \
  groupmod -g 1000 www-data && \
  # enable login for www-data user
  mkdir -p /home/www-data && \
  chown www-data:www-data /home/www-data && \
  usermod -d /home/www-data -s /bin/bash www-data

RUN apt update && apt install -y unzip net-tools iputils-ping procps

# Add Whale emoji and container ID to PS1
RUN /bin/bash -c "echo \"PS1='🐳 \[\033[1;36m\]\u@\h \[\033[1;34m\]\w\[\033[0;35m\] \[\033[1;36m\]# \[\033[0m\]'\" >> /home/www-data/.bashrc "

USER www-data

