nginx default:

server {
listen 80;
server_name localhost;

    #root /var/www/html;
    root /home/bacha/Desktop/task;
    index index.php index.html index.htm;

    location / {
        #alias /home/bacha/Desktop/task;  
        try_files $uri $uri/ /index.php;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}

