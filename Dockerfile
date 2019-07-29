FROM abiosoft/caddy:php
RUN apk add --no-cache php7-redis

WORKDIR /app

COPY Caddyfile /etc/
COPY php.ini /etc/php7/conf.d/php.ini

ENTRYPOINT ["/usr/bin/caddy"]
CMD ["--conf", "/etc/Caddyfile", "--log", "stdout"]
