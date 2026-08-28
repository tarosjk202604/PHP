# Windows PowerShell用の証明書作成スクリプト
# 実行するときは、
# .\create-certs.ps1
# と実行してください。先頭の # は入れないでね。

mkcert -key-file ssl/server.key -cert-file ssl/server.crt `
  localhost `
  project-a.local `
  food-science.tokyo `
  wp-exam.io

# ※ PowerShellでは、行末の「 ` 」（バッククォート）が「次の行へ続く」という意味になります。
# 今後ドメインを増やしたい場合は、最終行のドメインの後に「 ` 」を追加して次の行に記述してください。
# 「スクリプトの実行がシステムで無効...」と出た場合は、以下のコマンドを試してください。
# PowerShell -ExecutionPolicy Bypass -File .\create-certs.ps1