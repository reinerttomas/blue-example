ARG PHP_VERSION="8.1"

FROM reinerttomas/php:${PHP_VERSION}-apache-dev

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# INSTALLATION
RUN apt update && apt dist-upgrade -y && \
    # PHP EXTENSIONS
    install-php-extensions pdo_mysql && \
    # CLEAN UP
    apt-get clean -y && \
    apt-get autoclean -y && \
    apt-get autoremove -y && \
    rm -rf /var/lib/apt/lists/* /var/lib/log/* /tmp/* /var/tmp/*

RUN a2enmod rewrite
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf