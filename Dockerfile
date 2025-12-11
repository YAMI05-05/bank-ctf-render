FROM php:8.2-apache

# Install ping + curl
RUN apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y iputils-ping curl && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy vulnerable script
COPY audit.php /var/www/html/

# Add flag
RUN echo "softwarica{rc0mm4nd_1nj3ct10n_1s_st1ll_vuln3rabl3}" > /fl4g
RUN chmod 644 /fl4g

# Security: non-root
USER www-data