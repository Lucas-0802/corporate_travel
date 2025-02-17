# Usando PHP 8.2 como base
FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    mariadb-client \
    && docker-php-ext-install pdo_mysql mbstring gd xml

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www

# Copiar arquivos do projeto
COPY . .

# Ajustar permissões
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Instalar dependências do Laravel sem desenvolvimento (mas permite debug)
RUN composer install --no-dev --optimize-autoloader

# Gerar chave da aplicação
RUN php artisan key:generate

# Limpar cache do Laravel
RUN php artisan config:clear && \
    php artisan cache:clear && \
    php artisan view:clear && \
    php artisan route:clear

# Instalar Node.js e NPM (se necessário)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g n && \
    n 18.16.0 && \
    apt-get remove -y nodejs && \
    apt-get autoremove -y

# Expor porta do Laravel
EXPOSE 8000

# Comando para rodar o servidor e executar migrations + seeders
CMD php artisan migrate --seed && php artisan serve --host=0.0.0.0


