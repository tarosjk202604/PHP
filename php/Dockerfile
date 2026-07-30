FROM php:8.4-apache

# 必要なLinuxパッケージ（ライブラリ）のインストール
RUN apt-get update && apt-get install -y \
  libpng-dev \
  libjpeg-dev \
  libfreetype6-dev \
  libzip-dev \
  zip \
  unzip \
  msmtp \
  && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# GDライブラリの設定（JPGやPNGなどを扱えるようにする）
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# PHP拡張モジュールのインストール
RUN docker-php-ext-install \
  pdo_mysql \
  mysqli \
  gd \
  zip \
  opcache

# ApacheのURL書き換えモジュールを有効化（将来URLを綺麗にする際に必要になります）
RUN a2enmod rewrite

# PHPからMailpitにメールを転送するための設定（msmtpを使用）
# php.iniのsendmail_pathを上書きし、mailサービスの1025ポートへ転送させます
# デバッグ用の詳細ログ出力オプション「-d」を追加
# --read-envelope-from を追加し、送信者アドレスを自動検知させます
RUN echo "sendmail_path = \"/usr/bin/msmtp -t --host=mail --port=1025 --read-envelope-from\"" > /usr/local/etc/php/conf.d/mail.ini

# ApacheのSSLモジュールを有効化
RUN a2enmod ssl

# --- SSL証明書の設定 ---
# パターンA. デフォルトのSSL設定を使用する(今回はパターンBを採用するので、この設定は使わない)
# ApacheのデフォルトSSL設定ファイル内の証明書パスを、マウントしたカスタム証明書のパスに書き換える
# sedは「ファイルの中の文字を、検索して置き換える」コマンド
# sedは"Stream EDitor"の略で、ファイルを開かずに、中身の特定の文字列を一括で置き換えるためのLinuxコマンドです。
# sed -i 's!検索したい文字列!置き換えたい文字列!g' 対象ファイル
# RUN sed -i 's!/etc/ssl/certs/ssl-cert-snakeoil.pem!/etc/ssl/certs/server.crt!g' /etc/apache2/sites-available/default-ssl.conf \
#   && sed -i 's!/etc/ssl/private/ssl-cert-snakeoil.key!/etc/ssl/private/server.key!g' /etc/apache2/sites-available/default-ssl.conf

# ApacheのデフォルトのSSL設定（443ポートでのアクセス設定）を有効化
# RUN a2ensite default-ssl

# パターンB. バーチャルホストとHTTPS転送設定を読み込む
COPY apache/vhosts-ssl.conf /etc/apache2/sites-available/vhosts-ssl.conf

# vhosts-ssl.confの設定を有効化
RUN a2ensite vhosts-ssl