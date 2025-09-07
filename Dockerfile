# Pornim de la o imagine oficială PHP 8.4 cu serverul Apache.
FROM php:8.4-apache

# NOU: Actualizăm lista de pachete și instalăm dependențele de sistem necesare.
# `libsqlite3-dev` este pachetul de dezvoltare pentru SQLite.
RUN apt-get update && apt-get install -y libsqlite3-dev

# Acum, comanda de instalare a extensiei PHP va funcționa.
RUN docker-php-ext-install pdo pdo_sqlite

# Copiază tot conținutul folderului curent (proiectul tău)
# în folderul web al serverului Apache din container.
COPY . /var/www/html/

# Acesta este un pas cheie!
# Serverul Apache trebuie să aibă permisiunea de a scrie în baza de date.
# Această comandă face ca toate fișierele copiate să aparțină utilizatorului www-data.
RUN chown -R www-data:www-data /var/www/html/