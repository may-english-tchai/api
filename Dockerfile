#syntax=docker/dockerfile:1.4

FROM mkldevops/php-fpm-alpine:8.2

EXPOSE 80
CMD ["symfony", "serve", "--no-tls", "--allow-http", "--port=80"]
