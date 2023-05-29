FROM ubuntu:latest
LABEL authors="Danial"

FROM bitnami/laravel

# Copy application source
COPY . /app

ENTRYPOINT ["top", "-b"]
