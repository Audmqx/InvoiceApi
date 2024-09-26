FROM webdevops/php-nginx:8.3-alpine

# Installer les dépendances nécessaires, incluant sqlite-dev
RUN apk add --no-cache oniguruma-dev libxml2-dev sqlite-dev

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install \
        bcmath \
        ctype \
        fileinfo \
        mbstring \
        pdo_sqlite \
        xml

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir l'environnement et le répertoire de travail
ENV WEB_DOCUMENT_ROOT /app/public
ENV APP_ENV production
WORKDIR /app

# Copier tous les fichiers du projet dans le conteneur
COPY . .

# Configuration et installation
RUN cp -n .env.example .env

# Installer les dépendances Composer
RUN composer install --no-interaction --optimize-autoloader

# Générer les clés et mettre en cache la configuration
RUN php artisan key:generate
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Migration et seed (en SQLite, migration locale)
RUN php artisan migrate --force
RUN php artisan db:seed --force

# Donner les bonnes permissions au dossier
RUN chown -R application:application .