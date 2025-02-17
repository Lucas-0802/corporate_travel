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

# Instalar dependências do Laravel e gerar chave da aplicação
RUN composer install --no-dev --optimize-autoloader && \
    php artisan key:generate && \
    php artisan config:clear && \
    php artisan cache:clear

# Instalar Node.js e NPM
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
apt-get install -y nodejs && \
npm install -g n && \
n 18.16.0 && \
apt-get remove -y nodejs && \
apt-get autoremove -y

COPY . .

# Expor porta padrão do Laravel
EXPOSE 8000

# Comando para rodar o servidor e executar migrations + seeders
CMD php artisan migrate --seed && php artisan serve --host=0.0.0.0
