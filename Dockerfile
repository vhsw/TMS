FROM node:8 as node
COPY bower.json package.json package-lock.json /app/
WORKDIR /app
RUN npm install
RUN npx bower --allow-root install
COPY gulpfile.js /app/
COPY public /app/public
COPY resources /app/public/resources
# RUN npx gulp --production
RUN npx gulp -LLLL
RUN ls -la


FROM composer as composer
RUN docker-php-ext-install pdo pdo_mysql
# COPY . /var/www
COPY composer.json composer.lock /var/www/
COPY artisan  /var/www
COPY app /var/www/app
COPY bootstrap /var/www/bootstrap
COPY database /var/www/database
WORKDIR /var/www/
RUN composer install --no-dev --verbose --no-scripts



FROM php:5
RUN docker-php-ext-install pdo pdo_mysql
COPY . /var/www
COPY --from=composer /var/www /var/www
COPY --from=node /app/public /var/www/public
WORKDIR /var/www/
RUN mkdir -p storage/app \
    storage/framework \
    storage/framework/cache  \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs
EXPOSE 8080
CMD php artisan --verbose serve --host=0.0.0.0 --port=8080
