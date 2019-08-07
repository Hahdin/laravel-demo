FROM alpine

ENV \
  APP_DIR="/app" \
  APP_PORT="80"
WORKDIR $APP_DIR
# the "app" directory (relative to Dockerfile) containers your Laravel app...
COPY . $APP_DIR
RUN ls
RUN apk add --update \
    curl \
    php7 \
    php7-opcache \
    php7-mbstring \
    php7-fileinfo \
    php7-bcmath \
    php7-xmlwriter \
    php7-tokenizer \
    php7-openssl \
    php7-pdo \
    php7-json \
    php7-phar \
    php7-dom \
    php7-xml \
    php7-session \
    && rm -rf /var/cache/apk/*

RUN curl -sS https://getcomposer.org/installer | php -- \
  --install-dir=/usr/bin --filename=composer

RUN cd $APP_DIR
RUN composer install --no-dev
WORKDIR $APP_DIR
CMD php artisan serve --host=0.0.0.0 --port=$APP_PORT
# FROM php:7.3-cli
# RUN apt-get update
# RUN apt-get -y install sudo ufw systemd
# COPY . /usr/src/laravel-demo
# WORKDIR /usr/src/laravel-demo
# # Make port 80 available to the world outside this container
# EXPOSE 80
# RUN adduser --disabled-password --gecos '' docker
# RUN adduser docker sudo
# RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

# USER docker
# #RUN sudo apt-get install -y php-bcmath
# RUN sudo apt install -y php7.3-bcmath
# RUN sudo php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
# RUN sudo php -r "if (hash_file('sha384', 'composer-setup.php') === 'a5c698ffe4b8e849a443b120cd5ba38043260d5c4023dbf93e1558871f1f07f58274fc6f4c93bcfd858c6bd0775cd8d1') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
# RUN sudo php composer-setup.php
# RUN sudo php -r "unlink('composer-setup.php');"
# RUN sudo ./composer.phar install --no-dev

# CMD [ "php", "artisan", "serve" ]



# FROM ubuntu:18.04 as base
# WORKDIR /laravel-demo

# RUN apt-get update
# RUN apt-get -y install sudo

# RUN adduser --disabled-password --gecos '' docker
# RUN adduser docker sudo
# RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

# USER docker
# RUN sudo apt-get update 
# RUN sudo apt -y install  software-properties-common
# RUN sudo add-apt-repository ppa:ondrej/php
# RUN sudo apt-get install -y php7.3 php7.3-mbstring php7.3-xml php7.3-fpm php7.3-pdo php7.3-mysqlnd php7.3-bcmath
# COPY . /laravel-demo
# RUN cd /laravel-demo


# RUN sudo php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
# RUN sudo php -r "if (hash_file('sha384', 'composer-setup.php') === 'a5c698ffe4b8e849a443b120cd5ba38043260d5c4023dbf93e1558871f1f07f58274fc6f4c93bcfd858c6bd0775cd8d1') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
# RUN sudo php composer-setup.php
# RUN sudo php -r "unlink('composer-setup.php');"
# RUN sudo ./composer.phar install --no-dev
# EXPOSE 8000
# CMD [ "php", "artisan", "serve" ]
# # RUN sudo apt-get -y install apache2
# # RUN sudo ufw allow 'Apache'
# # RUN sudo systemctl status apache2





# # WORKDIR /laravel-demo
# # RUN apt-get update
# # RUN apt-get -y install sudo ufw systemd

# # RUN adduser --disabled-password --gecos '' docker
# # RUN adduser docker sudo
# # RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

# # USER docker

# # # this is where I was running into problems with the other approaches
# # RUN sudo apt-get update 
# # RUN sudo apt -y install  software-properties-common
# # RUN sudo add-apt-repository ppa:ondrej/php
# # RUN sudo apt-get install -y php7.3 php7.3-mbstring php7.3-xml php7.3-fpm php7.3-pdo php7.3-mysqlnd php7.3-bcmath
# # RUN sudo apt-get -y install apache2
# # RUN sudo ufw allow 'Apache'
# # RUN sudo systemctl status apache2

# # COPY . /laravel-demo
# # RUN cd /laravel-demo
# # RUN sudo php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
# # RUN sudo php -r "if (hash_file('sha384', 'composer-setup.php') === 'a5c698ffe4b8e849a443b120cd5ba38043260d5c4023dbf93e1558871f1f07f58274fc6f4c93bcfd858c6bd0775cd8d1') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
# # RUN sudo php composer-setup.php
# # RUN sudo php -r "unlink('composer-setup.php');"
# # RUN sudo ./composer.phar install --no-dev
# # # Make port 8000 available to the world outside this container
# # # EXPOSE 8000
# # # CMD ["php", "artisan", "serve"]
