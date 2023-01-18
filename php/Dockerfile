# SPDX-FileCopyrightText: 2023 Davidson <twister@davidson.fr>
# SPDX-License-Identifier: CC0-1.0

FROM php:8.0-apache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y
