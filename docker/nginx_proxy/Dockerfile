FROM nginx:latest

# COPY ./dockerfiles/nginx_proxy/nginx.conf /etc/nginx/conf.d/default.conf

# region Config for image_filter module
RUN apt-get update
RUN apt-get install -y nano
RUN apt-get install -y wget
RUN apt-get install -y gnupg2

RUN echo 'deb http://nginx.org/packages/ubuntu/ xenial nginx' >> /etc/apt/sources.list
RUN wget https://nginx.org/keys/nginx_signing.key
RUN apt-key add nginx_signing.key
RUN apt-get update
RUN apt-get install nginx-module-image-filter
# endregion Config for image_filter module

# Nginx Adding  image_filter module 
ADD ./nginx.conf /etc/nginx/nginx.conf
ADD ./proxy_config/nginx.conf /etc/nginx/conf.d/default.conf
ADD ./configs/modules/image/image_filter_servers.conf /etc/nginx/conf.d/modules/image/image_filter_servers.conf
# End Nginx Adding  image_filter module 

# RUN nginx -V
# RUN nginx -t

# RUN nginx -s reload
# RUN service nginx restart

WORKDIR /var/project
