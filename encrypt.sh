rm wordpress.sql.gz.enc
if [ -f *.sql ] ; then
   read -p "Enter the encryption key: " DB_ENCRYPTION_KEY
   gzip -k -8 $(echo *.sql)
   echo $DB_ENCRYPTION_KEY | openssl aes-256-cbc -a -salt -pbkdf2 -in $(echo *.sql.gz) -out wordpress.sql.gz.enc -pass stdin
   rm $(echo *.sql.gz)
   else echo "No sql file found.  Please add the sql file in the same directory as this script."
fi
