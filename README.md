
## Посмотреть онлайн
## http://18.188.184.56:8000/

## Установка

- Минимальные требования — PHP 7.2+, mysql 5.6.
- тестовое окружение: Ubuntu 16.04. 
- отредактируйте .env
- username: admin
- password: password

```bash
sudo apt install php libapache2-mod-php php-mbstring php-xmlrpc php-soap php-gd php-xml php-cli php-zip php-bcmath php-tokenizer php-json php-pear php7.2-mysql

mv .env.example .env
php composer.phar install
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan key:generate
php artisan serve
```

## Автор
> arysmukiyat@hotmail.com