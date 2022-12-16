FROM php:8.1-fpm

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libzip-dev\
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-configure gd 
RUN docker-php-ext-install pdo_mysql 
RUN docker-php-ext-install zip 
RUN docker-php-ext-install gd 

RUN docker-php-ext-enable zip 
RUN docker-php-ext-enable gd
RUN docker-php-ext-enable pdo_mysql 


# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

RUN composer install

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

# Các config :

# FROM — chỉ định image gốc: python, unbutu, alpine…
# LABEL — cung cấp metadata cho image. Có thể sử dụng để add thông tin maintainer. Để xem các label của images, dùng lệnh docker inspect.
# ENV — thiết lập một biến môi trường.
# RUN — Có thể tạo một lệnh khi build image. Được sử dụng để cài đặt các package vào container.
# COPY — Sao chép các file và thư mục vào container.
# ADD — Sao chép các file và thư mục vào container.
# CMD — Cung cấp một lệnh và đối số cho container thực thi. Các tham số có thể được ghi đè và chỉ có một CMD.
# WORKDIR — Thiết lập thư mục đang làm việc cho các chỉ thị khác như: RUN, CMD, ENTRYPOINT, COPY, ADD,…
# ARG — Định nghĩa giá trị biến được dùng trong lúc build image.
# ENTRYPOINT — cung cấp lệnh và đối số cho một container thực thi.
# EXPOSE — khai báo port lắng nghe của image.
# VOLUME — tạo một điểm gắn thư mục để truy cập và lưu trữ data.