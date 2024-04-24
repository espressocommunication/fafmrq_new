if [ -f *.sql.gz.enc ] ; then
   read -p "Enter the encryption key: " DB_ENCRYPTION_KEY
   echo $DB_ENCRYPTION_KEY | openssl aes-256-cbc -a -salt -pbkdf2 -d -in $(echo *.enc) -out ./wordpress.sql.gz -pass stdin
   gzip -d ./wordpress.sql.gz
   else echo "No encrypted sql file found.  Please add the encrypted sql file in the same directory as this script."
fi
