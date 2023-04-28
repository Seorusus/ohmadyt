FROM php:8.1-fpm

RUN curl -sL https://deb.nodesource.com/setup_16.x | bash

# persistent dependencies
RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
    # Ghostscript is required for rendering PDF previews
    ghostscript \
    nodejs \
    ssh-client \
    subversion \
    git \
    git-svn \
    nano \
    zip \
    unzip \
    rsync \
    ; \
    rm -rf /var/lib/apt/lists/*

RUN set -ex; \
    \
    savedAptMark="$(apt-mark showmanual)"; \
    \
    apt-get update; \
    apt-get install -y --no-install-recommends \
    git \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libzip-dev \
    libicu-dev \
    libxslt-dev \
    icu-devtools \
    ; \
    \
    docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    ; \
    docker-php-ext-install -j "$(nproc)" \
    bcmath \
    exif \
    gd \
    mysqli \
    pdo_mysql \
    zip \
    opcache \
    intl \
    ; \
    docker-php-source delete; \
    rm -rf /tmp/* /var/cache/* /var/www/html/*; \
    \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/*

RUN npm install --global pnpm yarn sass gulp-cli bower

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "copy('https://composer.github.io/installer.sig', 'composer-setup.sig');" && \
    php -r "if (hash_file('SHA384', 'composer-setup.php') === trim(file_get_contents('composer-setup.sig'))) { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');" && php -r "unlink('composer-setup.sig');"

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
    chmod +x wp-cli.phar && \
    mv wp-cli.phar /usr/local/bin/wp

RUN printf '\nwp() {\n  /usr/local/bin/wp "$@" --allow-root\n}\n' >> /root/.bashrc

RUN printf '\nfunction _update_ps1() {\n  PS1="$(powerline-go -modules venv,user,host,docker,docker-context,ssh,cwd,perms,git,hg,jobs,root,exit -hostname-only-if-ssh -colorize-hostname -error $? -jobs $(jobs | wc -l))"\n}\n\nif [ "$TERM" != "linux" ] && [ -f "/usr/local/bin/powerline-go" ]; then\n  PROMPT_COMMAND="_update_ps1; $PROMPT_COMMAND"\nfi\n' >> /root/.bashrc

VOLUME /var/www/html

ENV HOME=/root

RUN mkdir -p ~/.ssh && \
    echo "Host *\n\tStrictHostKeyChecking no\n\n" > ~/.ssh/config

WORKDIR /var/www/html
