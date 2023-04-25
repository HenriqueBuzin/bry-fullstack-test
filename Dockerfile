FROM php:8.0-apache

# Instala as extensões PHP necessárias
RUN docker-php-ext-install pdo pdo_mysql

# Ativa o módulo mod_rewrite do Apache
RUN a2enmod rewrite

# Copia o arquivo vhost.conf para o contêiner
COPY vhost.conf /etc/apache2/sites-available/000-default.conf

# Define o diretório de trabalho para o diretório raiz do aplicativo Laravel
WORKDIR /var/www/html

# Copia o código-fonte do aplicativo Laravel para o contêiner
COPY app/ .

# Define as permissões corretas no diretório de armazenamento de sessão
RUN chmod -R 777 storage

# Define as variáveis de ambiente para o MySQL
ENV DB_HOST db
ENV DB_PORT 3306
ENV DB_DATABASE laravel
ENV DB_USERNAME laravel
ENV DB_PASSWORD secret

# Expose port 80
EXPOSE 80

# Inicia o servidor Apache
CMD ["apache2-foreground"]
