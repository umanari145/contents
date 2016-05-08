#!/bin/sh
#Log Rotation Script AM 0:00

# ログファイルが置かれているフォルダ
LOGDIR="/opt/contents/app/Console/Command/"
# ログファイルを保管するフォルダ(今は同じフォルダに保管してる)
OLDLOGDIR="/opt/contents/app/Console/Command/logs/"

sleep 1

DATE=`date +%Y%m%d --date '1 day ago'`

LOGARR="log_order.txt log_girl.txt log.txt"

for file in $LOGARR
do
/bin/mv ${LOGDIR}/${file} ${OLDLOGDIR}/${file}.$DATE

# delete log file before 6 days
# 削除対象が存在しない時のために --no-run-if-empty オプションを指定
/usr/bin/find ${OLDLOGDIR}/${file}.* -mtime +5 | xargs --no-run-if-empty /bin/rm

echo "finish rotate ${file}"
done
