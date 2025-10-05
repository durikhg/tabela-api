# Usa PHP oficial
FROM php:8.2-cli

# Copia os arquivos
COPY . /app
WORKDIR /app

# Instala extensão para PostgreSQL
RUN docker-php-ext-install pdo_pgsql

# Expõe porta
EXPOSE 10000

# Inicia servidor PHP
CMD ["php", "-S", "0.0.0.0:10000", "api.php"]
