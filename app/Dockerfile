FROM node:14-alpine AS front_end
ENV NODE_ENV development
WORKDIR /app/front_end
COPY /front_end/package.json .
RUN npm install
COPY front_end .
EXPOSE 3000
CMD ["npm", "start"]

FROM php:8.1.9-fpm AS php
WORKDIR /app/app
RUN docker-php-ext-install pdo pdo_mysql mysqli
EXPOSE 9000