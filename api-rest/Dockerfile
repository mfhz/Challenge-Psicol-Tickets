#Imagen
FROM ubuntu:22.04

# Para que todos lo que instalemos sea desatendido
ENV DEBIAN_FRONTEND noninteractive

# Instalacion de PHP v8.1
RUN apt-get clean && apt-get -y update && apt-get install -y locales wget curl software-properties-common git \
  && locale-gen en_US.UTF-8
RUN LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php
RUN apt-get update -y
RUN apt-get upgrade -y
RUN apt-get install -y nano apt-transport-https php8.1-bcmath php8.1-bz2 php8.1-cli php8.1-common php8.1-curl \
  php8.1-cgi php8.1-dev php8.1-fpm php8.1-gd php8.1-gmp php8.1-imap php8.1-intl \
  php8.1-ldap php8.1-mbstring php8.1-mysql \
  php8.1-odbc php8.1-opcache php8.1-pgsql php8.1-phpdbg php8.1-pspell \
  php8.1-readline php8.1-soap php8.1-sqlite3 \
  php8.1-tidy php8.1-xml php8.1-xmlrpc php8.1-xsl php8.1-zip \
  php8.1-mongodb php8.1 mcrypt php-pear \
  php8.1-iconv php8.1-swoole

RUN apt-get update && apt-get install -y mysql-client && rm -rf /var/lib/apt


# Configuracion de PHP v8.1
RUN pear config-set php_ini /etc/php/8.1/fpm/php.ini

RUN sed -i "s/;date.timezone =.*/date.timezone = UTC/" /etc/php/8.1/cli/php.ini
RUN sed -i "s/;date.timezone =.*/date.timezone = UTC/" /etc/php/8.1/fpm/php.ini
RUN sed -i "s/memory_limit =.*/memory_limit = 1024M/" /etc/php/8.1/fpm/php.ini
RUN sed -i "s/display_errors = Off/display_errors = Off/" /etc/php/8.1/fpm/php.ini
RUN sed -i "s/upload_max_filesize = .*/upload_max_filesize = 100M/" /etc/php/8.1/fpm/php.ini
RUN sed -i "s/post_max_size = .*/post_max_size = 100M/" /etc/php/8.1/fpm/php.ini
RUN sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /etc/php/8.1/fpm/php.ini

RUN sed -i -e "s/pid =.*/pid = \/var\/run\/php8.1-fpm.pid/" /etc/php/8.1/fpm/php-fpm.conf
RUN sed -i -e "s/error_log =.*/error_log = \/proc\/self\/fd\/2/" /etc/php/8.1/fpm/php-fpm.conf
RUN sed -i -e "s/;daemonize\s*=\s*yes/daemonize = no/g" /etc/php/8.1/fpm/php-fpm.conf
RUN sed -i "s/listen = .*/listen = 9000/" /etc/php/8.1/fpm/pool.d/www.conf
RUN sed -i "s/;catch_workers_output = .*/catch_workers_output = yes/" /etc/php/8.1/fpm/pool.d/www.conf


# Instalacion de composer
RUN curl https://getcomposer.org/installer > composer-setup.php && php composer-setup.php && mv composer.phar /usr/local/bin/composer && rm composer-setup.php
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


# Directorio de trabajo del contenedor
WORKDIR /var/www/html


# Instalacion de nodeJS y NPM
RUN apt-get update
RUN apt-get -y install curl gnupg
RUN curl -sL https://deb.nodesource.com/setup_18.x  | bash -
RUN apt-get -y install nodejs


RUN apt-get update && apt-get install -y cron supervisor

COPY scheduler /etc/cron.d/scheduler
RUN chmod 0644 /etc/cron.d/scheduler \
  && crontab /etc/cron.d/scheduler

RUN mkdir -p /var/log/supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Como se va a llamar el servicio internamente
# nota: esto es necesario para poderlo comunicar con ngnix
CMD ["/usr/bin/supervisord"]
