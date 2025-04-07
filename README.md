## USE 

## Cara installation
1. composer install
2. copy .env.example dan ubah menjadi .env  
3. php artisan key:generate
4. docker-compose up --build -d

## cara masuk ke terminal dokcer
docker exec -it use-laravel-app bash
1. apt update && apt install nano -y
2. nano /etc/apache2/sites-available/000-default.conf
    tambahkan public menjadi /var/www/html/public
3. service apache2 restart

## cara masuk ke terminal mysql docker
docker exec -it mysql mysql -u root -p
echo "bind-address = 0.0.0.0" >> /etc/mysql/mysqld.cnf

mysql -h 127.0.0.1 -P 3307 -u root -p
ALTER USER 'root'@'%' IDENTIFIED WITH mysql_native_password BY 'root';
FLUSH PRIVILEGES;

##Copy image dari docker ke local
docker cp fe5042ea4a37:/var/www/html/storage/app/public/images /Users/asus/Downloads

##Setelah pull image di serve jalankan dan membuat volume dan konek ke container di serve Prod
docker volume create storage
docker run -d --name use ^
  -p 83:80 ^
  -v storage:/var/www/html/storage/app/public/images ^
  -v mysql-data:/var/lib/mysql ^
  jemmy22/use:1.1
## cara push image ke docker hub
1. docker login
2. docker images
3. docker-compose up -d --build
4. docker build -t use-laravel-app:v1.31 . -> use-laravel-app = di cek dari docker images
5. docker tag use-laravel-app:v1.31 jemmy22/use:v1.31   -> jemmy22/use:v1 nama yang ada di docker hub
6. docker push jemmy22/use:v1.31
