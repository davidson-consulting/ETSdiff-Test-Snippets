#! /bin/sh

ID=$(curl -s --location --request POST 'http://localhost:8080/files' --header 'Content-Type: multipart/form-data' --form 'file=@logo-davidson-simple.svg')
echo "=> File uploaded as $ID"

echo "--"

curl -s --location --request GET "http://localhost:8080/files/$ID" --output download
echo "Downloaded as 'download'"
diff -qs download logo-davidson-simple.svg
rm download

echo "--"

ls /tmp/$ID
curl -s --location --request DELETE "http://localhost:8080/files/$ID"
ls /tmp/$ID
