# 証明書発行用のシェルスクリプト
# 実行はターミナルにて、
# sh create-certs.sh
# と実行してください。先頭の#は入れないでね。
mkcert -key-file ssl/server.key -cert-file ssl/server.crt \
localhost \
project-a.local \
project-b.local \
pizzashop.local \
food-science.tokyo \
wp-exam.io 
# 必要になったら最終行のドメインの後ろに \ を追加して、新しいドメインを追加していきます