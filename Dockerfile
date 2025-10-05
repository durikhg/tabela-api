# Usa PHP oficial
FROM php:8.2-cli

# Instala dependências do sistema e PostgreSQL dev
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo_pgsql

# Copia os arquivos da API
COPY . /app
WORKDIR /app

# Expõe porta
EXPOSE 10000

# Inicia o servidor PHP
CMD ["php", "-S", "0.0.0.0:10000", "api.php"]
