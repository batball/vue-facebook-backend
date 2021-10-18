FROM nginx:alpine

COPY ./etc/web/cert/server.crt /etc/ssl/server.crt
COPY ./etc/web/cert/server.key /etc/ssl/server.key
COPY ./etc/web/httpd.conf /etc/nginx/conf.d/default.conf
