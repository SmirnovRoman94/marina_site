MYSQL_ROOT_PASSWORD=root
MYSQL_DATABASE=database
MYSQL_USER=user
MYSQL_PASSWORD=password
BACKUP_DIR=/backup
# Импортируем резервную копию базы данных
mysql -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/backup.sql