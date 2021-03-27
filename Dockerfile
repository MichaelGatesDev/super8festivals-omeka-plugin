FROM michaelgatesdev/omeka:2.8

# Download the theme because it's required for the plugin frontend to work
RUN curl -JL 'https://github.com/Super8Festivals/super8festivals-omeka-theme/archive/refs/heads/master.zip' -o /var/www/html/themes/super8festivals.zip \
    && unzip -q /var/www/html/themes/super8festivals.zip -d /var/www/html/themes/ \
    && rm /var/www/html/themes/super8festivals.zip \
    && mv /var/www/html/themes/super8festivals-omeka-theme-master /var/www/html/themes/SuperEightFestivals

# Copy plugin files over
RUN mkdir /var/www/html/plugins/SuperEightFestivals
COPY . /var/www/html/plugins/SuperEightFestivals/
