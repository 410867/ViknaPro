FROM postgres:15.0

RUN usermod -u 1000 www-data &&  \
    groupmod -g 1000 www-data &&  \
    mkdir -p /var/www/html &&  \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

USER www-data

WORKDIR /var/www/html